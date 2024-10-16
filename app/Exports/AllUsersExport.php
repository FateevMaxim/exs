<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AllUsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    use Importable;
    public function __construct()
    {}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = User::query()
            ->leftJoin('client_track_lists', 'users.id', '=', 'client_track_lists.user_id')
            ->select('users.id as user_id', 'users.*', DB::raw('COUNT(client_track_lists.track_code) as tracks_count'))
            ->groupBy('users.id')
            ->orderBy('tracks_count', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'user_id' => $user->user_id,
                    'tracks_count' => $user->tracks_count,
                    'user_data' => $user,
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
            $data['user_data']['login_date'] ?? '',
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
            'Дата последнего входа',
        ];
    }
}
