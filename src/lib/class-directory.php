<?php

namespace DirListing;

class Directory extends \DirListing\Singleton {

	// Current directory
	private $current_directory = '.';

	// Current files
	private $current_files = [];

	// Current directories
	private $current_directories = [];

	// Previous directory we were in.
	private $previous_directory = '';

	// Base script directory
	private $base_directory = '';

	protected function _init(){
		$this->base_directory = realpath(__DIR__ . '/../../');

		$directory = filter_input( INPUT_GET, 'dir', FILTER_SANITIZE_STRIPPED );
		$sanitized_directory = $this->sanitizeDirectory($directory);

		if (!empty( $sanitized_directory)) {
			$this->current_directory = realpath('./' . $directory);
			$this->previous_directory = dirname($this->current_directory);
		}

		try {
			$this->getDirectoryContent();
		} catch (\Exception $e ) {
			echo 'Error: ' . $e->getMessage();
		}
	}

	/**
	 * Make sure we are at the top level of the script.
	 *
	 * @param $dir
	 * @return string
	 */
	private function sanitizeDirectory($dir) {
		$base_directory_array = explode('/', $this->base_directory);
		$directory_array = explode('/', realpath($dir));

		if ( count($directory_array) >= count($base_directory_array) ) {
			return $dir;
		}

		return '';
	}

	/**
	 * Adds directory contents into $this->current_files
	 *
	 * @throws \Exception
	 */
	private function getDirectoryContent() {
		if (empty($this->current_directory)) {
			throw new \Exception('No Directory', 404);
		};

		$all = preg_grep('/^([^.])/', scandir($this->current_directory));
		foreach ($all as $file) {
			$actual_file = $this->current_directory . '/' . $file;
			if (is_file($actual_file)) {
				$this->addFile([
					'name' => $file,
					'dir' => $this->getCurrentSanitizedDirectory()
				]);
			} else {
				$this->addDirectory([
					'name' => $file,
					'dir' => $this->getCurrentSanitizedDirectory()
				]);
			}
		}
	}

	/**
	 * Add file to current file array.
	 *
	 * @param $file_arr
	 */
	private function addFile($file_arr) {
		$this->current_files[] = $file_arr;
	}

	/**
	 * Add directory to current directory array.
	 *
	 * @param $dir_arr
	 */
	private function addDirectory($dir_arr) {
		$this->current_directories[] = $dir_arr;
	}

	/**
	 * Returns current list of files.
	 *
	 * @return array
	 */
	public function getFiles() {
		return $this->current_files;
	}

	/**
	 * Returns current list of directories.
	 *
	 * @return array
	 */
	public function getDirectories() {
		return $this->current_directories;
	}

	/**
	 * Get previous directory.
	 *
	 * @return string
	 */
	public function getPreviousDirectory() {
		return $this->previous_directory;
	}

	/**
	 * Return current directory.
	 *
	 * @return string
	 */
	public function getCurrentDirectory() {
		return $this->current_directory;
	}

	public function getCurrentSanitizedDirectory() {
		return ltrim(str_replace($this->base_directory, '', $this->current_directory), '/');
	}

	public function getPreviousSanitizedDirectory() {
		return ltrim(str_replace($this->base_directory, '', $this->previous_directory), '/');
	}
}

Directory::Instance();