<?php

function _URL_($request, $array) {
    return Illuminate\Support\Facades\Request::fullUrlWithQuery(array_merge($array, $request));
}

function html_image($filename, $w, $h, $quality = 100, $id = null) {
    try {
        reloadThumb:
        $thumbnail_url = 'thumbnails/' . $w . '_' . $h . '/' . $filename . '.png';
        if (Storage::disk('localhost')->exists($thumbnail_url)) {
            return Storage::disk('localhost')->url($thumbnail_url);
        } else {
            $a = PhotoModel::where([
                        ['url_encode', '=', $filename]
                    ])->first();
            $thumb_url = 'public/thumbnails/' . $w . '_' . $h . '/';
            if (!Storage::disk('localhost')->exists($thumb_url)) {
                Storage::makeDirectory($thumb_url);
            }
            $url = Storage::disk('localhost')->url($a->url);
            if (!Storage::disk('localhost')->exists($thumbnail_url)) {
                $url_ = str_replace('https', 'http', $url);
                $thumb = Image::make($url_);
                $thumb->fit($w, $h);
                $thumb->save('storage/app/' . $thumb_url . $filename . '.png', $quality);
            }
            goto reloadThumb;
        }
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }
}

function html_thumbnail($filename, $w, $h, $quality = 100, $id = null) {
    try {
        reloadThumb:
        $thumbnail_url = 'thumbnails/' . $w . '_' . $h . '/' . $filename . '.png';
        if (Storage::disk('localhost')->exists($thumbnail_url)) {
            return Storage::disk('localhost')->url($thumbnail_url);
        } else {
            $a = PhotoModel::where([
                        ['url_encode', '=', $filename]
                    ])->first();
            $thumb_url = 'public/thumbnails/' . $w . '_' . $h . '/';
            if ($a == null) {
                return Storage::disk('localhost')->url('default/no-image.png');
            }
            if (!Storage::disk('localhost')->exists($a->url)) {
                return Storage::disk('localhost')->url('default/no-image.png');
            }
            $url = Storage::disk('localhost')->url($a->url);
            if (!Storage::disk('localhost')->exists($thumb_url)) {
                Storage::makeDirectory($thumb_url);
            }

            if (!Storage::disk('localhost')->exists($thumbnail_url)) {
                $url_ = str_replace('https', 'http', $url);
                $thumb = Image::make($url_);
                $thumb->fit($w, $h);
                $thumb->save('storage/app/' . $thumb_url . $filename . '.png', $quality);
            }
            goto reloadThumb;
        }
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }
}

function diffInNow($timestamps) {
    $now = \Carbon\Carbon::now();
    $time = new \Carbon\Carbon($timestamps);
    return $time->diffForHumans($now);
}

function public_bower($dir) {
    return asset('public/bower_components/' . $dir);
}
