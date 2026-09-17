# Activity Log System - Guide

## ✅ Fitur yang Sudah Diimplementasi

### 1. **Automatic Logging untuk Login & Logout**

System otomatis mencatat aktivitas login dan logout user melalui Event Listener.

**Location:** `app/Listeners/LogAuthentication.php`

```php
// Login event
activity('auth')
    ->causedBy($event->user)
    ->withProperties([
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ])
    ->log('login');

// Logout event
activity('auth')
    ->causedBy($event->user)
    ->withProperties([
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ])
    ->log('logout');
```

**Registered di:** `app/Providers/AppServiceProvider.php`

```php
Event::listen(Login::class, [LogAuthentication::class, 'handleLogin']);
Event::listen(Logout::class, [LogAuthentication::class, 'handleLogout']);
```

### 2. **Hapus Log Individual**

Setiap log memiliki tombol hapus individual di kolom "Aksi".

**Controller Method:**
```php
public function destroy($id)
{
    $activity = Activity::findOrFail($id);
    $activity->delete();
    
    return redirect()->route('activity-logs.index')
        ->with('success', 'Log aktivitas berhasil dihapus.');
}
```

**Route:**
```php
Route::delete('/activity-logs/{id}', [ActivityLogController::class, 'destroy'])
    ->name('activity-logs.destroy');
```

**View Button:**
```blade
<form action="{{ route('activity-logs.destroy', $log->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-glass-icon">
        <i class="bi bi-trash text-danger"></i>
    </button>
</form>
```

### 3. **Hapus Semua Log**

Tombol "Hapus Semua Log" di header page, dengan konfirmasi SweetAlert2.

**Features:**
- Hapus semua log sekaligus
- Respect filter yang aktif (module, event, date range)
- Konfirmasi sebelum menghapus
- Menampilkan jumlah log yang dihapus

**Controller Method:**
```php
public function destroyAll(Request $request)
{
    $query = Activity::query();
    
    // Apply filters if any
    if ($request->filled('module')) {
        $query->where('log_name', $request->input('module'));
    }
    
    if ($request->filled('event')) {
        $query->where('description', $request->input('event'));
    }
    
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->input('date_from'));
    }
    
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->input('date_to'));
    }
    
    $count = $query->count();
    $query->delete();
    
    return redirect()->route('activity-logs.index')
        ->with('success', "Berhasil menghapus {$count} log aktivitas.");
}
```

**Route:**
```php
Route::delete('/activity-logs', [ActivityLogController::class, 'destroyAll'])
    ->name('activity-logs.destroy-all');
```

**JavaScript Confirmation:**
```javascript
function confirmDeleteAll() {
  Swal.fire({
    title: "Hapus Semua Log Aktivitas?",
    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Ya, Hapus Semua!",
    cancelButtonText: "Batal"
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('deleteAllForm').submit();
    }
  });
}
```

---

## 📊 Filter System

Activity log memiliki filter lengkap:

### 1. **Search**
Cari berdasarkan:
- Nama user
- Username
- Log name (module)
- Description (event)

### 2. **Module Filter**
Filter berdasarkan modul:
- auth (login/logout)
- berita
- opd
- kecamatan
- pengumuman
- dll

### 3. **Event Filter**
Filter berdasarkan jenis aktivitas:
- created
- updated
- deleted
- login
- logout

### 4. **Date Range Filter**
- Date From: Tanggal mulai
- Date To: Tanggal akhir

### 5. **Reset Filter**
Tombol X untuk reset semua filter.

---

## 🎨 Badge Colors

Log aktivitas memiliki badge berwarna sesuai jenis:

| Event | Color | Icon |
|-------|-------|------|
| **created** | Green (#10b981) | bi-plus-circle |
| **updated** | Yellow (#ffc107) | bi-pencil-square |
| **deleted** | Red (#dc3545) | bi-trash |
| **login** | Cyan (#0dcaf0) | bi-box-arrow-in-right |
| **logout** | Gray (#6c757d) | bi-box-arrow-left |

---

## 📝 Log Properties Display

Untuk aktivitas CRUD (created, updated, deleted), tombol "Lihat Detail" menampilkan modal dengan JSON properties:

```blade
<button data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
    <i class="bi bi-file-earmark-code"></i>
</button>
```

Modal menampilkan:
- Perubahan data (old vs new values)
- Attributes yang dimodifikasi
- JSON formatted dengan syntax highlighting

---

## 🔒 Permission & Security

### Access Control:
- Hanya **Super Admin** yang bisa akses log aktivitas
- Route dilindungi oleh middleware `auth` dan `check.active`
- Gate `Super Admin` bypass all permissions

### Data yang Dicatat:
- User ID (causer)
- IP Address
- User Agent (Browser info)
- Timestamp
- Module/Model affected
- Action performed
- Changes made (properties)

---

## 🚀 Usage Examples

### Melihat Login/Logout History:
1. Buka menu "Log Aktivitas"
2. Filter Event: pilih "login" atau "logout"
3. Lihat IP address dan waktu akses

### Melihat Perubahan Data:
1. Filter Module: pilih modul (contoh: "berita")
2. Filter Event: pilih "updated"
3. Klik tombol detail untuk melihat perubahan

### Cleanup Old Logs:
1. Filter Date From/To: pilih range tanggal lama
2. Klik "Hapus Semua Log"
3. Konfirmasi untuk menghapus

### Hapus Log Specific User:
1. Search: masukkan nama user
2. Centang log yang ingin dihapus (atau hapus satu-satu)
3. Klik tombol hapus

---

## 📁 File Structure

```
app/
├── Http/Controllers/
│   └── ActivityLogController.php         # Controller dengan destroy methods
├── Listeners/
│   └── LogAuthentication.php             # Event listener untuk login/logout
└── Providers/
    └── AppServiceProvider.php            # Register event listeners

resources/views/
└── admin/
    └── activity_logs/
        └── index.blade.php                # View dengan tombol hapus

routes/
└── web.php                                # Routes: index, destroy, destroyAll
```

---

## 🎯 Testing Checklist

### ✅ Login/Logout Logging:
- [ ] Login user → Check log "login" muncul
- [ ] Logout user → Check log "logout" muncul
- [ ] IP address tercatat
- [ ] User agent tercatat

### ✅ Delete Individual:
- [ ] Klik tombol hapus pada 1 log
- [ ] Konfirmasi SweetAlert muncul
- [ ] Log terhapus dari database
- [ ] Success message muncul

### ✅ Delete All:
- [ ] Klik tombol "Hapus Semua Log"
- [ ] Konfirmasi muncul dengan jumlah log
- [ ] Semua log terhapus
- [ ] Success message dengan count

### ✅ Delete All with Filter:
- [ ] Aktifkan filter (contoh: module="auth")
- [ ] Klik "Hapus Semua Log"
- [ ] Hanya log sesuai filter yang terhapus
- [ ] Log module lain tetap ada

### ✅ Filters:
- [ ] Search by username works
- [ ] Module filter works
- [ ] Event filter works
- [ ] Date range filter works
- [ ] Reset filter works

---

## 🐛 Troubleshooting

### Log tidak tercatat saat login/logout:
**Check:**
1. Event listeners registered di `AppServiceProvider`
2. `LogAuthentication` class exists
3. Spatie Activity Log package installed
4. Database table `activity_log` exists

### Tombol hapus tidak muncul:
**Check:**
1. User adalah Super Admin
2. Route `activity-logs.destroy` terdaftar
3. CSRF token ada di form

### Delete All tidak bekerja:
**Check:**
1. Route `activity-logs.destroy-all` terdaftar
2. Method DELETE correct
3. Hidden form inputs contains filter values
4. SweetAlert2 loaded

---

## 💡 Best Practices

1. **Regular Cleanup:**
   - Hapus log lama secara berkala (contoh: > 6 bulan)
   - Keep database size manageable

2. **Monitoring:**
   - Check login/logout patterns untuk keamanan
   - Monitor failed login attempts

3. **Retention Policy:**
   - Define berapa lama log disimpan
   - Archive old logs jika perlu

4. **Performance:**
   - Index pada `created_at` column
   - Pagination untuk large datasets

---

## 🔄 Future Enhancements (Optional)

Fitur yang bisa ditambahkan:
- [ ] Export logs to CSV/Excel
- [ ] Filter by user role
- [ ] Archive instead of delete
- [ ] Scheduled auto-cleanup (Laravel scheduler)
- [ ] Log analytics dashboard
- [ ] Failed login tracking
- [ ] Suspicious activity alerts

---

*Last Updated: 2026-09-08*  
*Version: 1.0*
