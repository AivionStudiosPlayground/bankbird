<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddNoIndexHeaderForNonProdTest extends TestCase
{
    use RefreshDatabase;

    public function test_noindex_header_is_present_in_non_production_environment(): void
    {
        $this->app['env'] = 'local';

        $response = $this->get('/login');

        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_noindex_header_is_absent_in_production_environment(): void
    {
        $this->app['env'] = 'production';

        $response = $this->get('/login');

        $this->assertFalse($response->headers->has('X-Robots-Tag'));
    }
}
