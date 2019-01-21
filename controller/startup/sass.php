<<<<<<< Upstream, based on origin/master
<?php
class ControllerStartupSass extends Controller {
	public function index() {
		$file = DIR_APPLICATION . 'view/stylesheet/bootstrap.css';

		if (!is_file($file)) {
			$scss = new Scssc();
			$scss->setImportPaths(DIR_APPLICATION . 'view/stylesheet/sass/');

			$output = $scss->compile('@import "_bootstrap.scss"');

			$handle = fopen($file, 'w');

			flock($handle, LOCK_EX);

			fwrite($handle, $output);

			fflush($handle);

			flock($handle, LOCK_UN);

			fclose($handle);
		}
	}
}
=======
<<<<<<< HEAD
<?php
class ControllerStartupSass extends Controller {
	public function index() {
		$file = DIR_APPLICATION . 'view/stylesheet/bootstrap.css';

		if (!is_file($file)) {
			$scss = new Scssc();
			$scss->setImportPaths(DIR_APPLICATION . 'view/stylesheet/sass/');

			$output = $scss->compile('@import "_bootstrap.scss"');

			$handle = fopen($file, 'w');

			flock($handle, LOCK_EX);

			fwrite($handle, $output);

			fflush($handle);

			flock($handle, LOCK_UN);

			fclose($handle);
		}
	}
}
=======
<?php
class ControllerStartupSass extends Controller {
	public function index() {
		$file = DIR_APPLICATION . 'view/stylesheet/bootstrap.css';

		if (!is_file($file)) {
			$scss = new Scssc();
			$scss->setImportPaths(DIR_APPLICATION . 'view/stylesheet/sass/');

			$output = $scss->compile('@import "_bootstrap.scss"');

			$handle = fopen($file, 'w');

			flock($handle, LOCK_EX);

			fwrite($handle, $output);

			fflush($handle);

			flock($handle, LOCK_UN);

			fclose($handle);
		}
	}
}
>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
