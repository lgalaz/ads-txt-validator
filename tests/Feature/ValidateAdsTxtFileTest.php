<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateAdsTxtFileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_create_page()
    {
        $this->get(route('ads-file.create'))->assertSee('Choose Ads.txt file to upload');
    }

    /** @test */
    public function it_displays_error_when_file_is_not_passed_or_is_invalid()
    {
        $this->call('POST', route('ads-file.post'), [], [], [], ['Accept' => 'application/json'])
            ->assertRedirect(route('ads-file.create'))
            ->assertSessionHasErrors([
                'ads-file' => 'The uploaded ads.txt file as not found or is invalid.'
            ]);
    }

    /** @test */
    public function it_displays_errors_for_empty_ads_files()
    {
        $name = 'empty-ads-file.txt';
        $stub = __DIR__ . '/../stubs/' . $name;
        $path = sys_get_temp_dir() . '/' . $name;

        copy($stub, $path);

        $file = new UploadedFile($path, $name, 'text/plain', filesize($path), null, true);

        $this->call('POST', route('ads-file.post'), [], [], ['ads-file' => $file], ['Accept' => 'application/json'])
            ->assertRedirect(route('ads-file.create'))
            ->assertSessionHasErrors([
                'ads-file' => 'No valid records found.'
            ]);

        unlink(storage_path('app/uploads/') . session('name'));
    }

    /** @test */
    public function it_displays_errors_for_wrong_number_of_fields_in_record()
    {
        $name = 'invalid-ads-file.txt';
        $stub = __DIR__ . '/../stubs/' . $name;
        $path = sys_get_temp_dir() . '/' . $name;

        copy($stub, $path);

        $file = new UploadedFile($path, $name, 'text/plain', filesize($path), null, true);

        $this->call('POST', route('ads-file.post'), [], [], ['ads-file' => $file], ['Accept' => 'application/json'])
            ->assertRedirect(route('ads-file.create'))
            ->assertSessionHasErrors([
                'ads-file' => 'Wrong number of fields in record.'
            ]);

        unlink(storage_path('app/uploads/') . session('name'));
    }

    /** @test */
    public function it_displays_errors_for_wrong_var_declaration_in_record()
    {
        $name = 'invalid-var-declaration.txt';
        $stub = __DIR__ . '/../stubs/' . $name;
        $path = sys_get_temp_dir() . '/' . $name;

        copy($stub, $path);

        $file = new UploadedFile($path, $name, 'text/plain', filesize($path), null, true);

        $this->call('POST', route('ads-file.post'), [], [], ['ads-file' => $file], ['Accept' => 'application/json'])
             ->assertRedirect(route('ads-file.create'))
             ->assertSessionHasErrors([
                 'ads-file' => 'Invalid variable declaration in record.'
             ]);

        unlink(storage_path('app/uploads/') . session('name'));
    }

    /** @test */
    public function it_saves_valid_ads_txt_file()
    {
        $name = 'valid-ads-file.txt';
        $stub = __DIR__ . '/../stubs/' . $name;
        $path = sys_get_temp_dir() . '/' . $name;

        copy($stub, $path);

        $file = new UploadedFile($path, $name, 'text/plain', filesize($path), null, true);

        $content = $this->call('POST', route('ads-file.post'), [], [], ['ads-file' => $file], ['Accept' => 'application/json'])
             ->assertRedirect(route('ads-file.create'))
             ->assertSessionHas([
                 'success' => 'The ads file was created correctly.'
             ]);

        unlink(storage_path('app/uploads/') . session('name'));
    }
}
