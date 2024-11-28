<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\Autocomplete\Tests\Integration\Twig\Extension;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\UX\Autocomplete\Checksum\ChecksumCalculator;
use Symfony\UX\Autocomplete\Tests\Fixtures\Kernel;
use Symfony\UX\Autocomplete\Twig\Extension\RoutingExtension;
use Twig\Test\IntegrationTestCase;

final class RoutingExtensionTest extends IntegrationTestCase
{
    public static function getFixturesDirectory(): string
    {
        return __DIR__ . '/Fixtures/';
    }


    protected function getExtensions(): iterable
    {
        $kernel = new Kernel('test', true);
        $kernel->disableForms();
        $kernel->boot();

        $urlGenerator = $kernel->getContainer()->get(UrlGenerator::class);
        $checksumCalculator = $kernel->getContainer()->get(ChecksumCalculator::class);
        yield new RoutingExtension($urlGenerator, $checksumCalculator);
    }
}
