<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\CnsdActivities
 *
 * @property int $id
 * @property string|null $kode
 * @property string|null $dinas
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property string|null $waktu_mulai
 * @property string|null $waktu_selesai
 * @property string|null $alat
 * @property string|null $permasalahan
 * @property string|null $tindakan
 * @property string|null $hasil
 * @property string|null $status
 * @property string|null $waktu_terputus
 * @property array|null $teknisi
 * @property array|null $lampiran
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities query()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereAlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereLampiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities wherePermasalahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereTeknisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereTindakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereWaktuMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereWaktuSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdActivities whereWaktuTerputus($value)
 */
	class CnsdActivities extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CnsdEquipment
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdEquipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdEquipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdEquipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdEquipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdEquipment whereName($value)
 */
	class CnsdEquipment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CnsdSavedata
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string|null $dinas
 * @property string|null $mantek
 * @property string|null $nama_alat
 * @property \Illuminate\Support\Carbon|null $sampai
 * @property string|null $print
 * @property string|null $grup
 * @property string|null $file_path
 * @property string|null $file_name
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata query()
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereGrup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereMantek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereNamaAlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata wherePrint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CnsdSavedata whereType($value)
 */
	class CnsdSavedata extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DailyCnsdReports
 *
 * @property int $id
 * @property string|null $report_id_custom
 * @property string|null $dinas
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property string|null $jam
 * @property string|null $mantek
 * @property string|null $acknowledge
 * @property string|null $kode
 * @property string|null $jadwal_dinas
 * @property array|null $equipment_status
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereAcknowledge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereEquipmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereJadwalDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereJam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereMantek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereReportIdCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyCnsdReports whereUpdatedAt($value)
 */
	class DailyCnsdReports extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DailyTfpReports
 *
 * @property int $id
 * @property string|null $report_id_custom
 * @property string|null $dinas
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property string|null $jam
 * @property string|null $mantek
 * @property string|null $acknowledge
 * @property string|null $kode
 * @property string|null $jadwal_dinas
 * @property array|null $equipment_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereAcknowledge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereEquipmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereJadwalDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereJam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereMantek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereReportIdCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyTfpReports whereUpdatedAt($value)
 */
	class DailyTfpReports extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SaveDataTfp
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string|null $dinas
 * @property string|null $mantek
 * @property string|null $nama_alat
 * @property \Illuminate\Support\Carbon|null $sampai
 * @property string|null $print
 * @property string|null $grup
 * @property string|null $file_name
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereGrup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereMantek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereNamaAlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp wherePrint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveDataTfp whereType($value)
 */
	class SaveDataTfp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SchedulesCnsd
 *
 * @property int $id
 * @property string|null $schedule_id_custom
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property string|null $hari
 * @property string|null $dinas
 * @property string|null $teknisi_1
 * @property string|null $teknisi_2
 * @property string|null $teknisi_3
 * @property string|null $teknisi_4
 * @property string|null $teknisi_5
 * @property string|null $teknisi_6
 * @property string|null $kode
 * @property string|null $grup
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd query()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereGrup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereHari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereScheduleIdCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereTeknisi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereTeknisi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereTeknisi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereTeknisi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereTeknisi5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereTeknisi6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesCnsd whereUpdatedAt($value)
 */
	class SchedulesCnsd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SchedulesTfp
 *
 * @property int $id
 * @property string|null $schedule_id_custom
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property string|null $hari
 * @property string|null $dinas
 * @property string|null $teknisi_1
 * @property string|null $teknisi_2
 * @property string|null $teknisi_3
 * @property string|null $teknisi_4
 * @property string|null $teknisi_5
 * @property string|null $teknisi_6
 * @property string|null $kode
 * @property string|null $grup
 * @property string $created_at
 * @property string $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp query()
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereGrup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereHari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereScheduleIdCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereTeknisi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereTeknisi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereTeknisi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereTeknisi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereTeknisi5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereTeknisi6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SchedulesTfp whereUpdatedAt($value)
 */
	class SchedulesTfp extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TfpActivities
 *
 * @property int $id
 * @property string|null $kode
 * @property string|null $dinas
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property string|null $waktu_mulai
 * @property string|null $waktu_selesai
 * @property string|null $alat
 * @property string|null $permasalahan
 * @property string|null $tindakan
 * @property string|null $hasil
 * @property string|null $status
 * @property string|null $waktu_terputus
 * @property array|null $teknisi
 * @property array|null $lampiran
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities query()
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereAlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereDinas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereHasil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereLampiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities wherePermasalahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereTeknisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereTindakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereWaktuMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereWaktuSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpActivities whereWaktuTerputus($value)
 */
	class TfpActivities extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TfpEquipment
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|TfpEquipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TfpEquipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TfpEquipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|TfpEquipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TfpEquipment whereName($value)
 */
	class TfpEquipment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string|null $fullname
 * @property string $email
 * @property string $password
 * @property string|null $signature_url
 * @property string|null $avatar_url
 * @property string|null $phone_number
 * @property string $role
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSignatureUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkordersCnsd
 *
 * @method static \Illuminate\Database\Eloquent\Builder|WorkordersCnsd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkordersCnsd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkordersCnsd query()
 */
	class WorkordersCnsd extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkordersTfp
 *
 * @method static \Illuminate\Database\Eloquent\Builder|WorkordersTfp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkordersTfp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkordersTfp query()
 */
	class WorkordersTfp extends \Eloquent {}
}

