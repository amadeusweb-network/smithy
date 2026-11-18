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
