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
 * @property int $id
 * @property int $mechanic_id
 * @property string $date
 * @property string $status
 * @property string|null $work_unit
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttendanceDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Mechanic $mechanic
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereWorkUnit($value)
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $attendance_id
 * @property int $work_order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceDetail whereWorkOrderId($value)
 */
	class AttendanceDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode_bahan
 * @property string $nama_bahan
 * @property string $kategori
 * @property string|null $supplier
 * @property string|null $nomor_nota
 * @property float $stok
 * @property string $satuan
 * @property int $harga_satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BahanSpk> $penggunanSpk
 * @property-read int|null $penggunan_spk_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereKodeBahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereNamaBahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereNomorNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bahan whereUpdatedAt($value)
 */
	class Bahan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $work_order_id
 * @property int $bahan_id
 * @property float $jumlah_pakai
 * @property string $tanggal_pakai
 * @property string|null $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $mechanic_id
 * @property-read \App\Models\Bahan $bahan
 * @property-read \App\Models\Mechanic|null $mechanic
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereBahanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereJumlahPakai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereTanggalPakai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BahanSpk whereWorkOrderId($value)
 */
	class BahanSpk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $address
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $position
 * @property string|null $specialist
 * @property string|null $phone
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAllocation> $allocations
 * @property-read int|null $allocations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic whereSpecialist($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mechanic whereUpdatedAt($value)
 */
	class Mechanic extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $work_order_id
 * @property string $po_number
 * @property string $supplier_name
 * @property \Illuminate\Support\Carbon $order_date
 * @property string $status
 * @property numeric $total_amount
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseOrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder wherePoNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereWorkOrderId($value)
 */
	class PurchaseOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $purchase_order_id
 * @property int|null $work_order_detail_id
 * @property string $item_name
 * @property int $qty
 * @property numeric $price
 * @property numeric $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PurchaseOrder $purchaseOrder
 * @property-read \App\Models\WorkOrderDetail|null $workOrderDetail
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereWorkOrderDetailId($value)
 */
	class PurchaseOrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $customer_id
 * @property string $nopol
 * @property string $merk
 * @property string $model
 * @property string $warna
 * @property string|null $tahun
 * @property string|null $no_rangka
 * @property string|null $no_mesin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrder> $workOrders
 * @property-read int|null $work_orders_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereMerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereNoMesin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereNoRangka($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereNopol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vehicle whereWarna($value)
 */
	class Vehicle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $vehicle_id
 * @property int|null $mechanic_id
 * @property string $nomor_spk
 * @property string $status
 * @property int $progress
 * @property string $repair_stage
 * @property string $repair_type
 * @property string|null $keluhan_customer
 * @property string $tanggal_masuk
 * @property string|null $estimasi_selesai
 * @property numeric $estimasi_biaya
 * @property int $diskon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $foto_sebelum
 * @property string|null $foto_sesudah
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAllocation> $allocations
 * @property-read int|null $allocations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BahanSpk> $bahanSpks
 * @property-read int|null $bahan_spks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Mechanic|null $mechanic
 * @property-read \App\Models\Vehicle $vehicle
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDiskon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereEstimasiBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereEstimasiSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereFotoSebelum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereFotoSesudah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereKeluhanCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereNomorSpk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereRepairStage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereRepairType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereTanggalMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereVehicleId($value)
 */
	class WorkOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $work_order_id
 * @property int $mechanic_id
 * @property string $stage
 * @property string|null $start_time
 * @property string|null $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mechanic $mechanic
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereStage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAllocation whereWorkOrderId($value)
 */
	class WorkOrderAllocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $work_order_id
 * @property string $panel_name
 * @property string|null $kerusakan
 * @property string|null $part_status
 * @property string|null $part_location
 * @property string|null $part_eta
 * @property numeric $harga
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WorkOrder|null $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail whereKerusakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail wherePanelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail wherePartEta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail wherePartLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail wherePartStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderDetail whereWorkOrderId($value)
 */
	class WorkOrderDetail extends \Eloquent {}
}

