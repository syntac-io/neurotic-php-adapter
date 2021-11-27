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
			$content = $manager->getContent($contentTypeIdentifier)['items'];

			touch($contentTypePath);
			file_put_contents($contentTypePath, json_encode($content));
		}
    }
}