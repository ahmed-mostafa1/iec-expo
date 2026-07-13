<?php

namespace Tests\Unit;

use App\Services\HallSpaceService;
use PHPUnit\Framework\TestCase;

class HallSpaceServiceTest extends TestCase
{
    public function test_quartet_for_matches_known_clusters(): void
    {
        $this->assertSame(['L.W.1', 'L.W.2', 'L.W.29', 'L.W.30'], HallSpaceService::quartetFor('L.W.1'));
        $this->assertSame(['L.W.1', 'L.W.2', 'L.W.29', 'L.W.30'], HallSpaceService::quartetFor('L.W.30'));
        $this->assertSame(['R.W.59', 'R.W.60', 'R.W.87', 'R.W.88'], HallSpaceService::quartetFor('R.W.88'));
        $this->assertSame(['L.W.83', 'L.W.84', 'L.W.111', 'L.W.112'], HallSpaceService::quartetFor('L.W.112'));
        $this->assertSame([], HallSpaceService::quartetFor('CZ1'));
    }

    public function test_allowed_spaces_ranges(): void
    {
        $this->assertContains('L.W.28', HallSpaceService::allowedSpaces('icon-plus'));
        $this->assertNotContains('L.W.29', HallSpaceService::allowedSpaces('icon-plus'));

        $this->assertContains('R.W.29', HallSpaceService::allowedSpaces('icon'));
        $this->assertContains('CZ1', HallSpaceService::allowedSpaces('icon'));
        $this->assertNotContains('R.W.28', HallSpaceService::allowedSpaces('icon'));

        $this->assertContains('L.W.56', HallSpaceService::allowedSpaces('icon-plus-quartet'));
        $this->assertNotContains('L.W.57', HallSpaceService::allowedSpaces('icon-plus-quartet'));

        $this->assertContains('R.W.112', HallSpaceService::allowedSpaces('icon-quartet'));
        $this->assertNotContains('R.W.56', HallSpaceService::allowedSpaces('icon-quartet'));
    }
}
