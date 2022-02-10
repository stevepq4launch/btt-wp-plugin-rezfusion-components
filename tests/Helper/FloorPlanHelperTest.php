<?php

namespace Rezfusion\Helper\Registerer;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Rezfusion\Helper\AssetsRegisterer;
use Rezfusion\Helper\FloorPlanHelper;
use Rezfusion\Repository\FloorPlanRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class FloorPlanHelperTest extends BaseTestCase
{
    /**
     * @return MockObject
     */
    private function makeFloorPlanRepositoryMock(): MockObject
    {
        return $this->createMock(FloorPlanRepository::class);
    }

    /**
     * @param null|FloorPlanRepository $FloorPlanRepository
     * 
     * @return FloorPlanHelper
     */
    private function makeFloorPlanHelper($FloorPlanRepository = null): FloorPlanHelper
    {
        return new FloorPlanHelper(
            new AssetsRegisterer,
            !empty($FloorPlanRepository) ? $FloorPlanRepository : new FloorPlanRepository(TestHelper::makeAPI_TestClient(), '')
        );
    }

    public function testTruplaceProvider(): void
    {
        $this->assertSame('truplace', FloorPlanHelper::truplaceProvider());
    }

    public function testMatterportProvider(): void
    {
        $this->assertSame('matterport', FloorPlanHelper::matterportProvider());
    }

    public function testOtherProvider(): void
    {
        $this->assertSame('other', FloorPlanHelper::otherProvider());
    }

    public function testTruplaceURL(): void
    {
        $this->assertSame('tour.truplace.com', FloorPlanHelper::truplaceURL());
    }

    public function testMatterportURL(): void
    {
        $this->assertSame('matterport.com', FloorPlanHelper::matterportURL());
    }

    public function testTruplaceLinkWidgetURL(): void
    {
        $this->assertSame('https://tour.truplace.com/include/linkwidget.js', FloorPlanHelper::truplaceLinkWidgetURL());
    }

    public function testResolveProviderFromURL(): void
    {
        $FloorPlanHelper = $this->makeFloorPlanHelper();
        $this->assertSame('truplace', $FloorPlanHelper->resolveProviderFromURL('https://www.truplace.com/'));
        $this->assertSame('matterport', $FloorPlanHelper->resolveProviderFromURL('https://www.matterport.com/'));
        $this->assertSame('other', $FloorPlanHelper->resolveProviderFromURL('https://www.other.com/'));
    }

    public function testResolveProviderFromURLWithInvalidURL(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('URL is invalid.');
        ($this->makeFloorPlanHelper())->resolveProviderFromURL('');
    }

    public function testFindFloorPlanURLWithURLFromDatabase(): void
    {
        $expectedURL = 'https://www.truplace.com/1/1';
        $FloorPlanRepository = $this->makeFloorPlanRepositoryMock();
        $FloorPlanRepository->method('findURL_ForProperty')->willReturn($expectedURL);
        $FloorPlanHelper = $this->makeFloorPlanHelper($FloorPlanRepository);
        $this->assertSame($expectedURL, $FloorPlanHelper->findFloorPlanURL('test', 1));
    }

    public function testFindFloorPlanURLWithURLFromHub(): void
    {
        $expectedURL = 'https://www.truplace.com/1/1';
        $FloorPlanRepository = $this->makeFloorPlanRepositoryMock();
        $FloorPlanRepository->method('findOneByPostID')->willReturn(['url' => $expectedURL]);
        $FloorPlanHelper = $this->makeFloorPlanHelper($FloorPlanRepository);
        $this->assertSame($expectedURL, $FloorPlanHelper->findFloorPlanURL('test', 1));
    }

    public function testParseURLWithInvalidURL(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('URL is invalid.');
        ($this->makeFloorPlanHelper())->parseURL('');
    }

    public function testParseURLWithInvalidProvider(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Provider is invalid.');
        ($this->makeFloorPlanHelper())->parseURL('https://www.truplace.com/');
    }

    public function testParseURL(): void
    {
        $url = 'https://www.provider.com/';
        $this->assertSame(
            $url,
            ($this->makeFloorPlanHelper())->parseURL($url, 'other')
        );
    }

    public function testParseURLWithTruplaceProvider(): void
    {
        $this->assertSame(
            '/a/b/1/',
            ($this->makeFloorPlanHelper())->parseURL('https://www.truplace.com/a/b/1/', 'truplace')
        );
    }

    public function testPrepareShortcodeAttributesWithInvalidParameters(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Empty post ID and property key.');
        ($this->makeFloorPlanHelper())->prepareShortcodeAttributes();
    }

    public function testProviderRequiresElementSelector(): void
    {
        $FloorPlanHelper = $this->makeFloorPlanHelper();
        $this->assertTrue($FloorPlanHelper->providerRequiresElementSelector('truplace'));
        $this->assertFalse($FloorPlanHelper->providerRequiresElementSelector('metterport'));
        $this->assertFalse($FloorPlanHelper->providerRequiresElementSelector('other'));
    }

    public function testProviderRequiresElementSelectorWithInvalidProvider(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Provider is invalid.');
        ($this->makeFloorPlanHelper())->providerRequiresElementSelector('');
    }

    public function testHasFloorPlanURL(): void
    {
        $FloorPlanRepository = $this->makeFloorPlanRepositoryMock();
        $FloorPlanRepository->method('hasFloorPlan')->willReturn(true);
        $this->assertTrue(($this->makeFloorPlanHelper($FloorPlanRepository))->hasFloorPlanURL(1));
    }

    public function testPrepareShortcodeAttributesWithEmptyURL(): void
    {
        $FloorPlanRepository = $this->makeFloorPlanRepositoryMock();
        $FloorPlanRepository->method('findOneByPostID')->willReturn([]);
        $this->assertSame([], ($this->makeFloorPlanHelper($FloorPlanRepository))->prepareShortcodeAttributes('test', 1));
    }

    public function testPrepareShortcodeAttributes(): void
    {
        $FloorPlanRepository = $this->createMock(FloorPlanRepository::class);
        $FloorPlanRepository->method('findOneByPostID')->willReturn([
            'url' => 'http://www.truplace.com/1/1'
        ]);
        $this->assertSame(
            [
                'provider' => 'truplace',
                'url' => '/1/1'
            ],
            ($this->makeFloorPlanHelper($FloorPlanRepository))->prepareShortcodeAttributes('test', 1)
        );
    }
}
