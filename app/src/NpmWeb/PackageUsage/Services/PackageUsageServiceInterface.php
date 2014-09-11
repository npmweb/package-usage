<?php namespace NpmWeb\PackageUsage\Services;

interface PackageUsageServiceInterface {

    /**
     * Recalculates all usages with the latest information in the repos.
     */
    public function updateUsage( $owner );

    /**
     * Retrieves the usage results.
     */
    public function getUsage();

}
