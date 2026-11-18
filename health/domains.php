<?php

$domains = isset($_GET['domain']) ? $_GET['domain'] : false;
$items = [];

foreach (domain::$all as $id => $item) {
	$item = domain::cast($item);
	if ($domains && !in_array($id, $domains)) continue;

	$site = site::getInfo($item->folder . 'www', $item);
	if (!$site)
		showDebugging('www missing', $item->folder . 'www');
	else
		$items[] = appendSite($site, $item);

	foreach ($item->subFolders as $fol) {
		foreach ($item->getSites($fol) as $site)
			$items[] = appendSite($site, $item, $fol);
	}
}

features::ensureTables();
tableBuilder::factory(getPageParameterAt(), $items, ['classes' => 'table-wants-filter']);

function appendSite(site $site, domain $domain, $folder = '') {
	$array = (array)$site;
	unset($array['siteName']);
	unset($array['expectedLocalUrl']);
	$in = $domain->heading;
	if ($folder) $in .= ' (' . $folder . ')';
	$img = '<img src="'.$site->assetUrl . $site->key .'-logo.png" class="img-fluid img-max-200" />';
	$name = getLink($site->siteName . HRTAG . $img, $site->getUrl(_getUrlKeySansPreview()));
	return array_merge(['domain' => $in, 'site' => $name], $array);
}
