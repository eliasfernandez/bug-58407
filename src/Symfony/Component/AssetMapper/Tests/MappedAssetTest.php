<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\AssetMapper\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\AssetMapper\MappedAsset;

class MappedAssetTest extends TestCase
{
    public function testGetLogicalPath()
    {
        $asset = new MappedAsset('foo.css');

        $this->assertSame('foo.css', $asset->logicalPath);
    }

    public function testGetPublicPath()
    {
        $asset = new MappedAsset('anything');
        $asset->setPublicPath('/assets/foo.1234567.css');

        $this->assertSame('/assets/foo.1234567.css', $asset->getPublicPath());
    }

    public function testGetPublicPathWithoutDigest()
    {
        $asset = new MappedAsset('anything');
        $asset->setPublicPathWithoutDigest('/assets/foo.css');

        $this->assertSame('/assets/foo.css', $asset->getPublicPathWithoutDigest());
    }

    /**
     * @dataProvider getExtensionTests
     */
    public function testGetExtension(string $filename, string $expectedExtension)
    {
        $asset = new MappedAsset($filename);

        $this->assertSame($expectedExtension, $asset->getExtension());
    }

    public static function getExtensionTests(): iterable
    {
        yield 'simple' => ['foo.css', 'css'];
        yield 'with_multiple_dot' => ['foo.css.map', 'map'];
        yield 'with_directory' => ['foo/bar.css', 'css'];
    }

    public function testGetSourcePath()
    {
        $asset = new MappedAsset('foo.css');
        $asset->setSourcePath('/path/to/source.css');
        $this->assertSame('/path/to/source.css', $asset->getSourcePath());
    }

    public function testGetMimeType()
    {
        $asset = new MappedAsset('foo.css');
        $asset->setMimeType('text/css');
        $this->assertSame('text/css', $asset->getMimeType());
    }

    public function testGetDigest()
    {
        $asset = new MappedAsset('foo.css');
        $asset->setDigest('1234567', false);
        $this->assertSame('1234567', $asset->getDigest());
        $this->assertFalse($asset->isPredigested());
    }

    public function testGetContent()
    {
        $asset = new MappedAsset('foo.css');
        $asset->setContent('body { color: red; }');
        $this->assertSame('body { color: red; }', $asset->getContent());
    }
}