<?php
h2(humanize(getPageParameterAt()), cssUX::CenterContainer);
contentBox(nodeValue(), cssUX::container . ' mt-3');
echo '<form method="get" action="./">' . NEWLINE;

$autosubmit = ['onchange' => 'this.form.submit();'];

$items = ['' => 'Select Domain'];
foreach (domain::$all as $key => $item) {
	$item = domain::cast($item);
	$items[$key] = $item->heading;
}

echo tagUX::select('domain', $items, $previous = getQueryParameter('domain'), $autosubmit) . BRNL;

if ($previous) {
	$item = domain::$all[$previous];
	$items = ['' => 'Select Folder'];
	foreach ($item->subFolders as $key)
		$items[$key] = humanize($key);
	echo tagUX::select('folder', $items, $previous = getQueryParameter('folder'), $autosubmit) . BRNL;

	if ($previous) {
		$items = ['' => 'Select Site'];
		$items[$item->folder . 'www'] = site::getInfo($item->folder . 'www', $item)->siteName;
		foreach ($item->getSites($previous) as $site)
			$items[$site->path] = $site->siteName;
		echo tagUX::select('site', $items, $previous = getQueryParameter('site'), $autosubmit) . BRNL;

		if ($previous) {
			$site = site::getInfo($previous, $item);
			checkSite($site, $item);
		}
	}
}

echo '</form>' . NEWLINE;
contentBox('end');
