<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    
    private const REPLACEMENTS = [
        'Umbrella Inc.' => 'Business Umbrella',
        'شركة أمبريلا' => 'مظلة الأعمال',
    ];

    public function up(): void
    {
        $this->replace(self::REPLACEMENTS);
    }

    public function down(): void
    {
        $this->replace(array_flip(self::REPLACEMENTS));
    }

    private function replace(array $map): void
    {
        $row = DB::table('landing_sections')->where('section', 'registration')->first();

        if (! $row) {
            return;
        }

        $content = $row->content;

        foreach ($map as $from => $to) {
            $content = str_replace(
                [$from, trim(json_encode($from, JSON_UNESCAPED_SLASHES), '"')],
                [$to, trim(json_encode($to, JSON_UNESCAPED_SLASHES), '"')],
                $content
            );
        }

        if ($content !== $row->content) {
            DB::table('landing_sections')->where('id', $row->id)->update(['content' => $content]);
        }
    }
};
