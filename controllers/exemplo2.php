<?php
namespace gui\oi;

class oi{
	public function home(): string {
        return response()->json([
            'authenticated' => "po"
        ]);
    }
}