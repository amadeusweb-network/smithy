<?php
h2(humanize(getPageParameterAt()), cssUX::CenterContainer);
contentBox(nodeValue(), cssUX::container . ' mt-3');

$filter = (new healthFilters())->showInput();

foreach (domain::$all as $id => $item) {
	$item = domain::cast($item);
	if ($filter->skipDomain($id)) continue;

	echo cbCloseAndOpen(cssUX::container);
	h2($item->heading);
	checkSite(site::getInfo($item->folder . 'www', $item));

	foreach ($item->subFolders as $fol) {
		if ($filter->skipFolder($fol)) continue;
		echo cbCloseAndOpen(cssUX::container);

		h2($item->heading . ' &mdash; ' . humanize($fol));

		foreach ($item->getSites($fol) as $site)
			checkSite($site, $item);
	}
}

contentBox('end');
