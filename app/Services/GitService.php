<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GitService
{
    /**
     * Durée de mise en cache des informations Git (en secondes).
     */
    protected const CACHE_DURATION = 3600;

    /**
     * Retourne la branche Git actuelle.
     *
     * @return string|null
     */
    public function getCurrentBranch(): ?string
    {
        try {
            $headPath = base_path('.git/HEAD');
            if (!File::exists($headPath)) {
                return null;
            }

            $headContent = trim(File::get($headPath));
            
            if (str_starts_with($headContent, 'ref:')) {
                return basename(trim(str_replace('ref: refs/heads/', '', $headContent)));
            }

            return 'detached HEAD';
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    /**
     * Retourne les 8 premiers caractères du dernier commit.
     *
     * @return string|null
     */
    public function getLastCommitHash(): ?string
    {
        try {
            $logsHeadPath = base_path('.git/logs/HEAD');
            if (!File::exists($logsHeadPath)) {
                return null;
            }

            $lines = File::lines($logsHeadPath)->filter()->last();
            if (!$lines) {
                return null;
            }

            $parts = preg_split('/\s+/', $lines);
            
            if (isset($parts[1])) {
                return substr($parts[1], 0, 8);
            }

            return null;
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    /**
     * Retourne une version combinée du nom de la branche et du hash.
     *
     * @return string
     */
    public function getVersionInfo(): string
    {
        return Cache::remember('git_version_info', self::CACHE_DURATION, function () {
            $branch = $this->getCurrentBranch();
            $commit = $this->getLastCommitHash();
    
            if ($branch && $commit) {
                return __('Branch') . ': ' . $branch . ' | ' . __('Commit') . ': ' . $commit;
            }
    
            return __('Git info unavailable');
        });
    }
    
    /**
     * Vérifie si les informations Git sont disponibles.
     *
     * @return bool
     */
    public function hasGitInfo(): bool
    {
        return $this->getCurrentBranch() !== null && $this->getLastCommitHash() !== null;
    }
}