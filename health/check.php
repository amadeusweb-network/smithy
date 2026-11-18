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
	checkSite(site::getInfo($item->folder . 'www', $item));

	foreach ($item->subFolders as $fol) {
		if ($folders && !in_array($fol, $folders)) continue;
		echo cbCloseAndOpen(cssUX::container);

		h2($item->heading . ' &mdash; ' . humanize($fol));

		foreach ($item->getSites($fol) as $site)
			checkSite($site, $item);
	}
}

contentBox('end');
