<?php

namespace App\Service;

use App\Repository\ConfigurationParameterRepository;

/**
 * The configuration parameter service
 *
 * @package App\Service
 */
class ConfigurationParameterService
{
    const POSTS_PER_PAGE = 'POSTS_PER_PAGE';

    /** @var ConfigurationParameterRepository The configuration parameter repository. */
    private $configurationParameterRepository;

    /**
     * Configuration parameter service constructor.
     *
     * @param ConfigurationParameterRepository $configurationParameterRepository
     */
    public function __construct(ConfigurationParameterRepository $configurationParameterRepository)
    {
        $this->configurationParameterRepository = $configurationParameterRepository;
    }

    /**
     * Return the value of a configuration parameter.
     *
     * @param string $name The configuration parameter name.
     * @return int|object|null The configuration parameter value.
     */
    public function get(string $name)
    {
        $value = $this->configurationParameterRepository->findOneBy(['name' => $name]);

        if ($value === null) {
            // Return the default value
            switch ($name)
            {
                case self::POSTS_PER_PAGE:
                    $value = 10;
                    break;
            }
        }

        return $value;
    }
}