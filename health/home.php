<?php
contentBox(nodeValue(), cssUX::container . ' mt-3');
h2(getLink('All Domains', './'));
bootstrapAndUX::colouredDiv('These domains are cached from www/whois/network/sites.tsv and rendered using datatables...', bootstrapAndUX::warning, nodeValue());

function get_color($yes) { return $yes ? 'dark bg-success' : ''; }
function folderLink($folder, $domain = false, $root = false) {
	$name = $folder == 'all' ? 'All Folders' : humanize($folder);
	if (!$domain) $domain = getQueryParameter('domain');
	$qs = '/?domain=' . $domain . '&folder=' . $folder;
	return ($root ? '' : ' &mdash; ') . getLink('<u>' . $name . '</u>', pageUrl('health' . $qs), get_color(getQueryParameter('folder') == $folder))
		;
}

if ($domainId = getQueryParameter('domain')) {
	echo CBCO;
	$item = domain::$all[$domainId];
	variable('thisDomain', $item);

	if ($folderId = getQueryParameter('folder')) {
		h2('This Folder');
		echo folderLink($folderId, false, true) . BRNL;

		foreach ($item->subFolders as $folder) {
			if ($folderId != 'all' && $folderId != $folder) continue;
			$params = ['%subfol%' => $folder];
			$local = replaceItems($item->localBase, $params);
			$live = replaceItems($item->liveBase, $params);
			echo ' &mdash; ' . getLink($folder, '#') . ' &mdash;&gt; visit: ' . getLink($local, $local) . ' == ' . getLink($live, $live) . BRNL;
		}
		echo CBCO;
	}

	h2('This Domain\'s Folders', cssUX::m0);
	echo replaceItems('%1%%0%folders:%0%%folders%', [BRNL, $item->heading, 
		'folders' => folderLink('all') . BRNL . implode(BRNL, array_map(function ($fol) {  return folderLink($fol); }, $item->subFolders)),
	], WRAPREPLACE);
	echo CBCO;
}

if ($domainId) h2('This Domain', cssUX::m0);
$line = ($domainId ? '' : CBCO) . '%name%%nl%
mainSites:%nl%%sites%%nl%
';

foreach (domain::$all as $id => $item) {
	$item = domain::cast($item);
	if ($domainId && $domainId != $id) continue;
	variable('thisDomain', $item);

	echo replaceItems($line, [
		'nl' => BRNL,
		'name' => getLink($item->heading, pageUrl('health?domain=' . $id), get_color($domainId == $id)),
		'sites' => implode(BRNL, array_map(function ($site) { 
				return ' &mdash; ' . getLink('<u>' . $site . '</u>', replaceNetworkUrls('%urlOf-spring%health/?site=' . $site), get_color(getQueryParameter('site') == $site))
					. ' &mdash;&gt; visit: ' . getSiteLink($site, variable('thisDomain'));
			}, $item->mainSites)),
	], WRAPREPLACE);
}

contentBox('end');
