<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'Hapja e regjistrimeve për vitin shkollor 2026/27',
                'Regjistrimet fillojnë me datë 15 Qershor 2026. Kandidatët duhet të dorëzojnë dokumentacionin sipas udhëzimeve të publikuara në faqen zyrtare.'
            ],
            [
                'Njoftim për takim me prindër',
                'Takimi i përgjithshëm me prindër mbahet të Premten në ora 14:00 në sallën e takimeve. Pjesëmarrja rekomandohet për të gjithë.'
            ],
            [
                'Orari i konsultimeve me profesorë',
                'Prindërit dhe nxënësit mund të rezervojnë termine për konsultime përmes platformës online në seksionin Takimet.'
            ],
            [
                'Dita e aktiviteteve shkollore',
                'Të Mërkurën organizohen aktivitete edukative dhe sportive për nxënësit. Prezenca është e obligueshme sipas orarit të klasës.'
            ],
            [
                'Kanali zyrtar i komunikimit',
                'Të gjitha njoftimet zyrtare publikohen në këtë platformë dhe në faqen tonë zyrtare në Facebook. Ju lutem përcillni rregullisht për përditësime.'
            ]
        ];

        foreach ($items as $it) {
            Announcement::updateOrCreate(
                ['title' => $it[0]],
                [
                    'content' => $it[1],
                    'audience' => 'all',
                    'created_by_user_id' => null,
                ]
            );
        }
    }
}
