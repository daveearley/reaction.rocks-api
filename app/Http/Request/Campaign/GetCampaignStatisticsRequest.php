<?php

namespace App\Http\Request\Campaign;

use App\Http\Request\BaseRequest;

class GetCampaignStatisticsRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'start_date' => ['date', 'date_format:d-m-Y'],
            'end_date' => ['date', 'after:start_date', 'date_format:d-m-Y'],
        ];
    }
}