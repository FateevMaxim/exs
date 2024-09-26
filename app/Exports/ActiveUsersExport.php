<?php

namespace App\Exports;

use App\Models\ClientTrackList;
use App\Models\TrackList;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ActiveUsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    use Importable;
    public function __construct()
    {}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = ClientTrackList::query()->select('user_id', DB::raw('COUNT(track_code) as tracks_count'))
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('tracks_count', 'desc')
            ->get()
            ->map(function ($trackList) {
                return [
                    'user_id' => $trackList->user_id,
                    'tracks_count' => $trackList->tracks_count,
                    'user_data' => $trackList->user,  // Модель пользователя
                ];
            });

        return $data;
    }

    /**
     * @param $data
     * @return array
     */
    public function map($data): array
    {
        return [
            $data['user_id'],
            $data['tracks_count'],
            $data['user_data']['name'] ?? '',
            $data['user_data']['login'] ?? '',
            $data['user_data']['city'] ?? '',
        ];
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function headings(): array
    {
        return [
            'ID пользователя',
            'Количество треков',
            'Имя',
            'Телефон',
            'Город',
        ];
    }
}
