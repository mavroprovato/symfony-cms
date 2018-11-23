<?php

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * The content status
 */
class ContentStatusType extends AbstractEnumType
{
    /** @var string Draft content status */
    public const DRAFT = 'DRAFT';
    /** @var string Published content status */
    public const PUBLISHED = 'PUBLISHED';
    /** @var string Deleted content status */
    public const DELETED = 'DELETED';

    /** {@inheritdoc} */
    protected static $choices = [
        self::DRAFT => 'Draft',
        self::PUBLISHED => 'Published',
        self::DELETED => 'Deleted'
    ];
}