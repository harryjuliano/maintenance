## Maintenance Operations App (Laravel + Inertia + React)

Project ini adalah refactor starter-kit menjadi aplikasi **Maintenance Operations** untuk tim maintenance harian dengan target **zero breakdown** dan pendekatan ISO 9001:2015:

- **Process approach** (request → triage → WO → eksekusi → verifikasi → evaluasi)
- **Risk-based thinking** (critical asset, critical spare part, overdue PM alert)
- **Documented information** (WO, checklist, downtime, approval trail, RCA/CAPA)
- **Performance evaluation** (KPI reliability)
- **Continual improvement** (analisis trend dan tindakan perbaikan)

## Stack

- Laravel 11
- Inertia.js + React
- Tailwind CSS
- Chart.js

## Modul utama yang disiapkan

1. Dashboard Operasional Maintenance
2. Asset & Reliability
3. Work Request & Work Order
4. Preventive Maintenance
5. Spare Part Control
6. RCA / CAPA
7. Reporting & KPI
8. Administration (users, roles, permissions)

## KPI inti (zero breakdown)

- Breakdown count
- Downtime hours
- MTTR / MTBF
- PM compliance
- Emergency WO ratio
- Repeat breakdown rate
- Spare part stockout rate
- Response time vs SLA

## Jalankan project

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```

## Akses default (seeder)

- email: `raf@dev.com`
- password: `password`

## Catatan roadmap implementasi

### Fase 1
- Asset master
- Work request
- Work order
- Dashboard dasar
- Role access

### Fase 2
- Preventive maintenance scheduler
- Inspection checklist
- Downtime tracking
- Spare part control
- Notification

### Fase 3
- RCA & CAPA
- Reliability KPI lanjutan
- Planner calendar
- Mobile flow teknisi
- Integrasi lintas sistem
