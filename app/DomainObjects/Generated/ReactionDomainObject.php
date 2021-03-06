<?php

declare(strict_types=1);

namespace App\DomainObjects\Generated;

/**
 * THIS FILE IS AUTOGENERATED - DO NOT EDIT IT DIRECTLY.
 *
 * Class ReactionDomainObject
 * @package App\DomainObjects\Generated
 */
abstract class ReactionDomainObject extends \App\DomainObjects\AbstractDomainObject
{
    /** @var string */
    public const SINGULAR_NAME = 'reaction';

    /** @var string */
    public const PLURAL_NAME = 'reactions';

    /** @var string */
    public const ID = 'id';

    /** @var string */
    public const CAMPAIGN_ID = 'campaign_id';

    /** @var string */
    public const SCORE = 'score';

    /** @var string */
    public const EMOJI = 'emoji';

    /** @var string */
    public const FEEDBACK_MESSAGE = 'feedback_message';

    /** @var string */
    public const USER_AGENT_DATA = 'user_agent_data';

    /** @var string */
    public const CLIENT_IDENTIFIER = 'client_identifier';

    /** @var string */
    public const COUNTRY_CODE = 'country_code';

    /** @var string */
    public const CITY = 'city';

    /** @var string */
    public const BROWSER = 'browser';

    /** @var string */
    public const BROWSER_VERSION = 'browser_version';

    /** @var string */
    public const PLATFORM = 'platform';

    /** @var string */
    public const REFERER = 'referer';

    /** @var string */
    public const CLIENT_IP = 'client_ip';

    /** @var string */
    public const CREATED_AT = 'created_at';

    /** @var string */
    public const UPDATED_AT = 'updated_at';

    /** @var string */
    public const DELETED_AT = 'deleted_at';

    /** @var string */
    public const USER_DATA = 'user_data';

    /** @var int */
    protected int $id;

    /** @var int */
    protected int $campaign_id;

    /** @var int */
    protected int $score;

    /** @var string */
    protected string $emoji;

    /** @var string */
    protected ?string $feedback_message = null;

    /** @var string */
    protected ?string $user_agent_data = null;

    /** @var string */
    protected ?string $client_identifier = null;

    /** @var string */
    protected ?string $country_code = null;

    /** @var string */
    protected ?string $city = null;

    /** @var string */
    protected ?string $browser = null;

    /** @var string */
    protected ?string $browser_version = null;

    /** @var string */
    protected ?string $platform = null;

    /** @var string */
    protected ?string $referer = null;

    /** @var string */
    protected ?string $client_ip = null;

    /** @var string */
    protected ?string $created_at = null;

    /** @var string */
    protected ?string $updated_at = null;

    /** @var string */
    protected ?string $deleted_at = null;

    /** @var string */
    protected ?string $user_data = null;

   /**
    * @return array
    */
    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'campaign_id' => $this->campaign_id ?? null,
            'score' => $this->score ?? null,
            'emoji' => $this->emoji ?? null,
            'feedback_message' => $this->feedback_message ?? null,
            'user_agent_data' => $this->user_agent_data ?? null,
            'client_identifier' => $this->client_identifier ?? null,
            'country_code' => $this->country_code ?? null,
            'city' => $this->city ?? null,
            'browser' => $this->browser ?? null,
            'browser_version' => $this->browser_version ?? null,
            'platform' => $this->platform ?? null,
            'referer' => $this->referer ?? null,
            'client_ip' => $this->client_ip ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
            'deleted_at' => $this->deleted_at ?? null,
            'user_data' => $this->user_data ?? null,
        ];
    }
    
   /**
    * @param int $id
    * @return self
    */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

   /**
    * @return int
    */
    public function getId(): int
    {
        return $this->id;
    }

   /**
    * @param int $campaign_id
    * @return self
    */
    public function setCampaignId(int $campaign_id): self
    {
        $this->campaign_id = $campaign_id;

        return $this;
    }

   /**
    * @return int
    */
    public function getCampaignId(): int
    {
        return $this->campaign_id;
    }

   /**
    * @param int $score
    * @return self
    */
    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

   /**
    * @return int
    */
    public function getScore(): int
    {
        return $this->score;
    }

   /**
    * @param string $emoji
    * @return self
    */
    public function setEmoji(string $emoji): self
    {
        $this->emoji = $emoji;

        return $this;
    }

   /**
    * @return string
    */
    public function getEmoji(): string
    {
        return $this->emoji;
    }

   /**
    * @param string $feedback_message
    * @return self
    */
    public function setFeedbackMessage(?string $feedback_message): self
    {
        $this->feedback_message = $feedback_message;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getFeedbackMessage(): ?string
    {
        return $this->feedback_message;
    }

   /**
    * @param string $user_agent_data
    * @return self
    */
    public function setUserAgentData(?string $user_agent_data): self
    {
        $this->user_agent_data = $user_agent_data;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getUserAgentData(): ?string
    {
        return $this->user_agent_data;
    }

   /**
    * @param string $client_identifier
    * @return self
    */
    public function setClientIdentifier(?string $client_identifier): self
    {
        $this->client_identifier = $client_identifier;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getClientIdentifier(): ?string
    {
        return $this->client_identifier;
    }

   /**
    * @param string $country_code
    * @return self
    */
    public function setCountryCode(?string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

   /**
    * @param string $city
    * @return self
    */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getCity(): ?string
    {
        return $this->city;
    }

   /**
    * @param string $browser
    * @return self
    */
    public function setBrowser(?string $browser): self
    {
        $this->browser = $browser;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getBrowser(): ?string
    {
        return $this->browser;
    }

   /**
    * @param string $browser_version
    * @return self
    */
    public function setBrowserVersion(?string $browser_version): self
    {
        $this->browser_version = $browser_version;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getBrowserVersion(): ?string
    {
        return $this->browser_version;
    }

   /**
    * @param string $platform
    * @return self
    */
    public function setPlatform(?string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

   /**
    * @param string $referer
    * @return self
    */
    public function setReferer(?string $referer): self
    {
        $this->referer = $referer;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getReferer(): ?string
    {
        return $this->referer;
    }

   /**
    * @param string $client_ip
    * @return self
    */
    public function setClientIp(?string $client_ip): self
    {
        $this->client_ip = $client_ip;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getClientIp(): ?string
    {
        return $this->client_ip;
    }

   /**
    * @param string $created_at
    * @return self
    */
    public function setCreatedAt(?string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

   /**
    * @param string $updated_at
    * @return self
    */
    public function setUpdatedAt(?string $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

   /**
    * @param string $deleted_at
    * @return self
    */
    public function setDeletedAt(?string $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getDeletedAt(): ?string
    {
        return $this->deleted_at;
    }

   /**
    * @param string $user_data
    * @return self
    */
    public function setUserData(?string $user_data): self
    {
        $this->user_data = $user_data;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getUserData(): ?string
    {
        return $this->user_data;
    }
}