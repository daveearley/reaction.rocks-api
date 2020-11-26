<?php

namespace App\Validator;

use App\DomainObjects\Enums\WidgetStartBehaviour;
use App\DomainObjects\Enums\WidgetStatsDisplayType;
use App\DomainObjects\Enums\WidgetTabPositionEnum;
use App\DomainObjects\Enums\WidgetTypeEnum;

class CampaignValidator extends BaseValidator
{
    private const URL_REGEX = '/[a-zA-Z0-9@:%._\+~#=]+\.[a-z]+[:]?([0-9]+)?/i';

    public function rules(array $options = []): array
    {
        return [
            'name' => 'required|max:100',
            'allowed_domains.*' => sprintf('regex:%s', self::URL_REGEX),
            'type' => $this->emumValidator(WidgetTypeEnum::class),
            'tab_position' => $this->emumValidator(WidgetTabPositionEnum::class),
            "positive_question" => 'max:300',
            "negative_question" => 'max:300',
            "neutral_question" => 'max:300',
            "heading" => ['required', 'max:255'],
            "sub_heading" => 'max:255',
            "start_behaviour" => $this->emumValidator(WidgetStartBehaviour::class),
            "only_show_on_first_session" => 'boolean',
            "tab_text_color" => 'max:7',
            "tab_background_color" => 'max:7',
            "tab_text" => 'required|max:32',
            "thank_you_message" => 'max:300',
            "emojis" => ['required', 'max:50'],
            "emoji_titles" => 'max:120',
            "show_stats" => 'boolean',
            "stats_display_type" => $this->emumValidator(WidgetStatsDisplayType::class),
            "button_background_color" => 'max:7',
            "button_text_color" => 'max:7',
        ];
    }
}