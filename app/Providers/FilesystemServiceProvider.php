<?php
namespace UpstatePHP\Website\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;
use Dropbox\Client;

class FilesystemServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app['config'];

        $this->app->bind('offsite-backup', function() use ($config)
        {
            $client = new Client(
                $config->get('filesystems.disks.dropbox.accessToken'),
                $config->get('filesystems.disks.dropbox.appSecret')
            );
            $adapter = new DropboxAdapter($client);

            return new Filesystem($adapter);
        });
    }
}
