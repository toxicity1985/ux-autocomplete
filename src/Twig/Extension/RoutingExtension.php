<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Autocomplete\Twig\Extension;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\Autocomplete\Checksum\ChecksumCalculator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RoutingExtension extends AbstractExtension
{
    public function __construct(
        private readonly UrlGeneratorInterface $generator,
        private readonly ChecksumCalculator    $checksumCalculator,
    )
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('ux_autocomplete_path', $this->getUxAutocompletePath(...)),
        ];
    }

    public function getUxAutocompletePath(string $name, array $parameters = [], bool $relative = false): string
    {
        if (!empty($parameters) && array_key_exists('extra_options', $parameters)) {
            $checksum = $this->checksumCalculator->calculateForArray($parameters['extra_options']);
            $parameters['extra_options'] = base64_encode(json_encode(array_merge($parameters['extra_options'], ['@checksum' => $checksum])));
        }
        return $this->generator->generate($name, $parameters, $relative);
    }
}
