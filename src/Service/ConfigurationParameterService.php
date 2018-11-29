<?php

namespace App\Service;

use App\Entity\ConfigurationParameter;
use App\Repository\ConfigurationParameterRepository;

/**
 * The configuration parameter service
 *
 * @package App\Service
 */
class ConfigurationParameterService
{
    /** @var string The site title parameter name */
    const SITE_TITLE = 'SITE_TITLE';
    /** @var string The site sub-title parameter name */
    const SITE_SUBTITLE = 'SITE_SUBTITLE';
    /** @var string The site URL parameter name */
    const SITE_URL = 'SITE_URL';
    /** @var string The name of the posts per page parameter */
    const POSTS_PER_PAGE = 'POSTS_PER_PAGE';

    /** @var array The default values for the configuration parameters */
    private static $DEFAULT_VALUES = [
        self::SITE_TITLE => 'Title',
        self::SITE_SUBTITLE => 'Subtitle',
        self::SITE_URL => '',
        self::POSTS_PER_PAGE => 10,
    ];

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
     * @return mixed The configuration parameter value.
     */
    public function get(string $name)
    {
        $value = $this->configurationParameterRepository->findOneBy(['name' => $name]);

        if ($value === null) {
            // Return the default value
            return self::$DEFAULT_VALUES[$name] ?? null;
        }

        return $value;
    }

    /**
     * Return all the parameters, with the default values.
     *
     * @return array
     */
    public function all(): array
    {
        $parameterArray = [];

        // Add the parameters from the database
        $parameters = $this->configurationParameterRepository->findAll();
        /** @var ConfigurationParameter $parameter */
        foreach ($parameters as $parameter) {
            $parameterArray[$parameter->getName()] = $parameter->getValue();
        }

        // Add missing parameters from the default values
        foreach (self::$DEFAULT_VALUES as $key => $value) {
            if (!array_key_exists($key, $parameterArray)) {
                $parameterArray[$key] = self::$DEFAULT_VALUES[$key];
            }
        }

        return $parameterArray;
    }
}