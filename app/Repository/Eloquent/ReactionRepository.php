<?php

namespace App\Repository\Eloquent;

use App\DomainObjects\ReactionDomainObject;
use App\Models\Reaction;
use App\Repository\Interfaces\ReactionRepositoryInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReactionRepository extends BaseRepository implements ReactionRepositoryInterface
{
    public function getDomainObject(): string
    {
        return ReactionDomainObject::class;
    }

    public function getTotalReactionPerEmoji(int $campaignId, Carbon $fromDate = null, Carbon $toDate = null): array
    {
        $dateRange = '';
        if ($fromDate && $toDate) {
            $dateRange = sprintf(
                "and created_at between '%s' and '%s'",
                $fromDate->format('Y-m-d'),
                $toDate->addDay()->format('Y-m-d')
            );
        }

        $sql = <<<SQL
            SELECT emoji, count(*) count, round(count(*) * 100.0 / sum(count(*)) over(), 2) percentage
            FROM reactions
            WHERE campaign_id = {$campaignId}
            {$dateRange}
            GROUP BY emoji
SQL;

        return $this->db->select($sql);
    }

    public function getAverageAndCountForDateRange(int $campaignId, CarbonPeriod $period, bool $isNpsCampaign): array
    {
        $npsClause = $isNpsCampaign ? "
                       CAST(((
                         SUM(CASE WHEN score BETWEEN 9 AND 10 THEN 1 ELSE 0 END) -
                         SUM(CASE WHEN score BETWEEN 0 AND 6 THEN 1 ELSE 0 END)
                     ) / COUNT(*) * 100) AS int) as nps_score," : null;

        $npsSelect = $isNpsCampaign ? ', nps_score' : '';

        $sql = <<<SQL
            SELECT a.date, coalesce(average, 0) as average, coalesce(count, 0) as count {$npsSelect}
            FROM (
                     SELECT d::date date
                     FROM generate_series
                              ( '{$period->getStartDate()->format('Y-m-d')}'::date
                              , '{$period->getEndDate()->format('Y-m-d')}'::date
                              , '1 day'::interval) d
                 ) a
                     LEFT OUTER JOIN (
                SELECT round(avg(score), 2) as average,
                       count(*) as count, 
                       {$npsClause}
                       created_at::date
                FROM reactions
                WHERE campaign_id = {$campaignId}
                GROUP BY created_at::date
            ) b ON a.date::date = b.created_at::date
            order by 1;
SQL;

        return $this->db->select($sql);
    }

    public function getCountForLastXDaysAndAverageScore(int $campaignId): ?object
    {
        $last30 = Carbon::today()->subDays(30)->format('Y-m-d');
        $last7 = Carbon::today()->subDays(7)->format('Y-m-d');
        $lastDay = Carbon::today()->subDays(1)->format('Y-m-d');

        $sql = <<<SQL
            SELECT
                   count(*) AS total,
                   sum(case when created_at > '{$last30}' then 1 else 0 end) AS reactions_last_30_days,
                   sum(case when created_at > '{$last7}' then 1 else 0 end) AS reactions_last_7_days,
                   sum(case when created_at > '{$lastDay}' then 1 else 0 end) AS reactions_last_day,
                   CAST(((
                      SUM(CASE WHEN score BETWEEN 9 AND 10 THEN 1 ELSE 0 END) * 1.0 -
                      SUM(CASE WHEN score BETWEEN 0 AND 6 THEN 1 ELSE 0 END)
                    ) / COUNT(*) * 100) AS int) as nps,
                   
                   
                   round(avg(score), 2) as average_score
            FROM reactions
            WHERE campaign_id = {$campaignId}
            GROUP BY campaign_id;
SQL;

        return $this->db->selectOne($sql);
    }

    protected function getModel(): string
    {
        return Reaction::class;
    }
}