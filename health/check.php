<?php
h2(humanize(getPageParameterAt()), cssUX::CenterContainer);
contentBox(nodeValue(), cssUX::container . ' mt-3');

$domains = isset($_GET['domain']) ? $_GET['domain'] : false;
$folders = isset($_GET['folder']) ? $_GET['folder'] : false;

if ($folders && count($folders)) {
	$replace = [];
	$domains = [];
	foreach ($folders as $item) {
		$bits = explode('--', $item);
		if (!in_array($bits[0], $domains))
			$domains[] = $bits[0];
		if (!in_array($bits[1], $replace))
			$replace[] = $bits[1];
	}
	$folders = $replace;
}

function csvOrNone($array) {
	return $array ? implode(', ', $array) : 'none';
}

echo '<h3>Input</h3><div class="bg-info bg-gradient p-2 rounded-5"><b>domains</b>: ' . csvOrNone($domains) . ', <b>folders</b>: ' . csvOrNone($folders) . '</div>';

foreach (domain::$all as $id => $item) {
	$item = domain::cast($item);
	if ($domains && !in_array($id, $domains)) continue;

	echo cbCloseAndOpen(cssUX::container);
	h2($item->heading);
	check(site::getInfo($item->folder . 'www', $item));

	foreach ($item->subFolders as $fol) {
		if ($folders && !in_array($fol, $folders)) continue;
		echo cbCloseAndOpen(cssUX::container);

		h2($item->heading . ' &mdash; ' . humanize($fol));

		foreach ($item->getSites($fol) as $site)
			check($site, $item);
	}
}

function check(site $site, domain $domain = null) {
	$mismatch = [];

	if ($site->expectedLocalUrl != $site->localUrl)
		$mismatch[] = 'local: ' . printReadable(['given' => $site->localUrl, 'expected' => $site->expectedLocalUrl]);

	if ($domain) {
		$expectedLive = $domain->getSiteInfo($site->parentFolder, $site->folder, VARLive);
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

contentBox('end');
