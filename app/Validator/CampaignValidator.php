<?php

namespace App\Validator;

use App\DomainObjects\Enums\WidgetDisplayTypeEnum;
use App\DomainObjects\Enums\WidgetStartBehaviour;
use App\DomainObjects\Enums\WidgetStatsDisplayType;
use App\DomainObjects\Enums\WidgetTabPositionEnum;
use App\DomainObjects\Enums\CampaignTypeEnum;

class CampaignValidator extends BaseValidator
{
    private const URL_REGEX = '/[a-zA-Z0-9@:%._\+~#=]+\.[a-z]+[:]?([0-9]+)?/i';

    public function rules(array $options = []): array
    {
        return [
            'name' => ['required', 'max:100'],
            'allowed_domains.*' => sprintf('regex:%s', self::URL_REGEX),
            'display_type' => [$this->emumValidator(WidgetDisplayTypeEnum::class), 'required'],
            'type' => [$this->emumValidator(CampaignTypeEnum::class), 'required'],
            'tab_position' => [$this->emumValidator(WidgetTabPositionEnum::class), 'required'],
            "start_behaviour" => [$this->emumValidator(WidgetStartBehaviour::class), 'required'],
            "stats_display_type" => $this->emumValidator(WidgetStatsDisplayType::class),
            "positive_question" => ['max:150', 'required_if:is_follow_up_mandatory,true'],
            "negative_question" => ['max:150', 'required_if:is_follow_up_mandatory,true'],
            "neutral_question" => ['max:150', 'required_if:is_follow_up_mandatory,true'],
            "heading" => ['required', 'max:150'],
            "sub_heading" => 'max:150',
            "only_show_on_first_session" => 'boolean',
            "tab_text_color" => 'max:9',
            "tab_background_color" => 'max:9',
            "tab_text" => ['required', 'max:32'],
            "thank_you_message" => 'max:300',
            "emojis" => ['required', 'max:50'],
            "emoji_titles" => 'max:120',
            "show_stats" => 'boolean',
            "button_background_color" => 'max:9',
            "button_text_color" => 'max:9',
            "ask_follow_up_question" => ['bool'],
            "is_follow_up_mandatory" => ['bool']
        ];
    }

    public function messages(): array
    {
        return [
            'positive_question.required_if' => 'This field is required',
            'negative_question.required_if' => 'This field is required',
            'neutral_question.required_if' => 'This field is required',
        ];
    }
}