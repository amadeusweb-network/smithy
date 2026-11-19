<?php

function checkSite(site $site, domain $domain = null) {
	$mismatch = [];

	if ($site->expectedLocalUrl != $site->localUrl)
		$mismatch[] = 'local: ' . printReadable(['given' => $site->localUrl, 'expected' => $site->expectedLocalUrl]);

	if ($domain) {
		$expectedLive = $domain->getSiteInfo($site->parentFolder, $site->folder, VARLive);
		$expectedLive = str_replace('www.', '', $expectedLive);
		if ($expectedLive != $site->liveUrl)
			$mismatch[] = 'live: ' . printReadable(['given' => $site->liveUrl, 'expected' => $expectedLive]);
	}

	if (getQueryParameter('mismatch') && count($mismatch) == 0) return;

	echo cbCloseAndOpen(cssUX::container);
	$img = !getQueryParameter('slim') ? '%br%<img src="%logo%" class="img-fluid img-max-400 d-block m-1 m-auto" />' : '';
	$loader = !getQueryParameter('slim') ? '%hr%%nl%<iframe src="%health%"></iframe>' : '';
	echo replaceItems('<h3>%match%<a href="%health%" target="_blank">%health%</a>%br%<a href="%url%" target="_blank">%name%' . $img . '</a>' . $loader . '%nl%%nl%', [
			'hr' => HRTAG, 'br' => BRNL, 'nl' => NEWLINE,
			'url' => $url = $site->getUrl(_getUrlKeySansPreview()),
			'health' => $url . '?health=1',
			'name' => $site->name,
			'logo' => $site->assetUrl . $site->key . '-logo.png',
			'match' => bootstrapAndUX::colouredDiv(count($mismatch) ? 'url mismatch<pre>' . implode(BRNL, $mismatch) .'</pre>' : 'urls match', count($mismatch) ? bootstrapAndUX::danger : bootstrapAndUX::success),
		], WRAPREPLACE);
}

class healthFilters {
	public $domains;
	public $folders;

	public function __construct()
	{
		$this->domains = valueIfSet($_GET, 'domain', false);
		$this->folders = valueIfSet($_GET, 'folder', false);

		

		if ($this->folders && count($this->folders)) {
				$replace = [];
				$domains = [];
				foreach ($this->folders as $item) {
					$bits = explode('--', $item);
					if (!in_array($bits[0], $domains))
						$domains[] = $bits[0];
					if (!in_array($bits[1], $replace))
						$replace[] = $bits[1];
				}
				$this->domains = $domains;
				$this->folders = $replace;
		}
	}

	private function csvOrNone($array) {
		return $array ? implode(', ', $array) : 'none';
	}

	function showInput() {
		echo '<h3>Input</h3><div class="bg-info bg-gradient p-2 rounded-5"><b>domains</b>: '
			. self::csvOrNone($this->domains) . ', <b>folders</b>: '
			. self::csvOrNone($this->folders) . '</div>';
		return $this;
	}

	function skipDomain($id) {
		return $this->domains && !in_array($id, $this->domains);
	}

	function skipFolder($id) {
		return $this->folders && !in_array($id, $this->folders);
	}
}
