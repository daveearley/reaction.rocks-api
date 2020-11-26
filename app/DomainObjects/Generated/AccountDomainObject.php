<?php

declare(strict_types=1);

namespace App\DomainObjects\Generated;

/**
 * THIS FILE IS AUTOGENERATED - DO NOT EDIT IT DIRECTLY.
 *
 * Class AccountDomainObject
 * @package App\DomainObjects\Generated
 */
abstract class AccountDomainObject extends \App\DomainObjects\AbstractDomainObject
{
    /** @var string */
    public const SINGULAR_NAME = 'account';

    /** @var string */
    public const PLURAL_NAME = 'accounts';

    /** @var string */
    public const ID = 'id';

    /** @var string */
    public const PARENT_ID = 'parent_id';

    /** @var string */
    public const FIRST_NAME = 'first_name';

    /** @var string */
    public const LAST_NAME = 'last_name';

    /** @var string */
    public const PASSWORD = 'password';

    /** @var string */
    public const EMAIL = 'email';

    /** @var string */
    public const CREATED_AT = 'created_at';

    /** @var string */
    public const UPDATED_AT = 'updated_at';

    /** @var string */
    public const DELETED_AT = 'deleted_at';

    /** @var int */
    protected int $id;

    /** @var int */
    protected ?int $parent_id = null;

    /** @var string */
    protected ?string $first_name = null;

    /** @var string */
    protected ?string $last_name = null;

    /** @var string */
    protected string $password;

    /** @var string */
    protected string $email;

    /** @var string */
    protected ?string $created_at = null;

    /** @var string */
    protected ?string $updated_at = null;

    /** @var string */
    protected ?string $deleted_at = null;

   /**
    * @return array
    */
    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'parent_id' => $this->parent_id ?? null,
            'first_name' => $this->first_name ?? null,
            'last_name' => $this->last_name ?? null,
            'password' => $this->password ?? null,
            'email' => $this->email ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
            'deleted_at' => $this->deleted_at ?? null,
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
    * @param int $parent_id
    * @return self
    */
    public function setParentId(?int $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }

   /**
    * @return int|null
    */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

   /**
    * @param string $first_name
    * @return self
    */
    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

   /**
    * @param string $last_name
    * @return self
    */
    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

   /**
    * @return string|null
    */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

   /**
    * @param string $password
    * @return self
    */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

   /**
    * @return string
    */
    public function getPassword(): string
    {
        return $this->password;
    }

   /**
    * @param string $email
    * @return self
    */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

   /**
    * @return string
    */
    public function getEmail(): string
    {
        return $this->email;
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
}