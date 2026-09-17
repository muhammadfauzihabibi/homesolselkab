<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Unduhan;
use App\Models\KategoriUnduhan;
use App\Models\JenisUnduhan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnduhanDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_download_tracking_increments_counter()
    {
        // Create test data
        $kategori = KategoriUnduhan::factory()->create([
            'nama' => 'Test Kategori',
            'slug' => 'test-kategori',
            'aktif' => true
        ]);

        $jenis = JenisUnduhan::factory()->create([
            'kategori_unduhan_id' => $kategori->id,
            'nama' => 'Test Jenis',
            'slug' => 'test-jenis',
            'aktif' => true
        ]);

        $unduhan = Unduhan::factory()->create([
            'kategori_unduhan_id' => $kategori->id,
            'jenis_unduhan_id' => $jenis->id,
            'judul' => 'Test Document',
            'slug' => 'test-document-12345',
            'google_drive_url' => 'https://drive.google.com/file/d/1ABC123DEF456/view?usp=sharing',
            'jumlah_unduhan' => 5,
            'aktif' => true
        ]);

        // Test download tracking
        $response = $this->get(route('frontend.unduhan.download', $unduhan->slug));

        // Should redirect to Google Drive
        $response->assertRedirect();
        $response->assertRedirectContains('drive.google.com');

        // Should increment download counter
        $unduhan->refresh();
        $this->assertEquals(6, $unduhan->jumlah_unduhan);
    }

    public function test_google_drive_url_conversion()
    {
        $unduhan = new Unduhan([
            'google_drive_url' => 'https://drive.google.com/file/d/1ABC123DEF456/view?usp=sharing'
        ]);

        $directUrl = $unduhan->getDirectDownloadUrl();
        
        $this->assertEquals(
            'https://drive.google.com/uc?export=download&id=1ABC123DEF456',
            $directUrl
        );
    }

    public function test_inactive_document_returns_404()
    {
        $unduhan = Unduhan::factory()->create([
            'slug' => 'inactive-document',
            'aktif' => false
        ]);

        $response = $this->get(route('frontend.unduhan.download', $unduhan->slug));
        
        $response->assertNotFound();
    }
}