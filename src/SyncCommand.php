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

		if (is_dir($baseDir)) {
			rmdir($baseDir);
		}

		mkdir($baseDir);

		foreach ($manager->getContentTypes()['items'] as $contentTypeIdentifier => $contentType) {
			$contentTypePath = $baseDir . '/' . $contentTypeIdentifier . '.json';
			touch($contentTypePath);
			file_put_contents($contentTypePath, json_encode($contentType));

			if (!is_dir($dir = $baseDir . '/' . $contentTypeIdentifier)) {
				mkdir($dir);
			}

			foreach ($manager->getContent($contentTypeIdentifier)['items'] as $itemIdentifier => $item) {
				$itemPath = $dir . '/' . $itemIdentifier . '.json';
				touch($itemPath);
				file_put_contents($itemPath, json_encode($item));
			}
		}
    }
}