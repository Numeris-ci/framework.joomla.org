<?php
/**
 * Joomla! Framework Website
 *
 * @copyright  Copyright (C) 2014 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace Joomla\FrameworkWebsite\View\Package;

use Joomla\FrameworkWebsite\Model\{
	PackageModel, ReleaseModel
};
use Joomla\View\BaseJsonView;

/**
 * Package JSON view class for the application
 *
 * @since  1.0
 */
class PackageJsonView extends BaseJsonView
{
	/**
	 * The active package
	 *
	 * @var  string
	 */
	private $package = '';

	/**
	 * The package model object.
	 *
	 * @var  PackageModel
	 */
	private $packageModel;

	/**
	 * The release model object.
	 *
	 * @var  ReleaseModel
	 */
	private $releaseModel;

	/**
	 * Instantiate the view.
	 *
	 * @param   PackageModel  $packageModel  The package model object.
	 * @param   ReleaseModel  $releaseModel  The release model object.
	 */
	public function __construct(PackageModel $packageModel, ReleaseModel $releaseModel)
	{
		$this->packageModel = $packageModel;
		$this->releaseModel = $releaseModel;
	}

	/**
	 * Method to render the view
	 *
	 * @return  string  The rendered view
	 */
	public function render()
	{
		$package = $this->packageModel->getPackage($this->package);
		$releases = $this->releaseModel->getPackageHistory($package);

		// Remove the ID and package ID for each item
		foreach ($releases as $release)
		{
			unset($release->id, $release->package_id);
		}

		unset($package->id);

		$this->setData(
			[
				'releases' => $releases,
				'package'  => $package,
			]
		);

		$this->setData(['releases' => $releases]);

		return parent::render();
	}

	/**
	 * Set the active package
	 *
	 * @param   string  $package  The active package name
	 *
	 * @return  void
	 */
	public function setPackage(string $package)
	{
		$this->package = $package;
	}
}
