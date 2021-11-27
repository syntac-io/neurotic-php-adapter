<?php

namespace Syntac\Neurotic;

use Illuminate\Console\Command;

class SyncCommand extends Command
{
	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neurotic:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all content types and published content.';

    /**
     * Execute the console command.
     *
     * @param  \Syntac\Neurotic\NeuroticManager  $drip
     * @return mixed
     */
    public function handle(NeuroticManager $manager)
    {
        $baseDir = storage_path('neurotic');

		rmdir($baseDir);
		mkdir($baseDir);

		foreach ($manager->getContentTypes() as $contentType) {
			$contentTypeIdentifier = $contentType['identifier'];
			if (!is_dir($dir = $baseDir . '/' . $contentTypeIdentifier)) {
				mkdir($dir);
			}
			
			$contentTypePath = $baseDir . '/' . $contentTypeIdentifier . '.json';
			touch($contentTypePath);
			file_put_contents($contentTypePath, json_encode($contentType));

			foreach ($manager->getContent($contentTypeIdentifier) as $item) {
				$itemPath = $dir . '/' . $item['identifier'] . '.json';
				touch($itemPath);
				file_put_contents($itemPath, json_encode($item));
			}
		}
    }
}