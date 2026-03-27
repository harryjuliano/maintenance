import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconChecklist, IconDeviceFloppy } from '@tabler/icons-react';

const defaultData = {
    asset_id: '',
    inspection_type: 'daily_check',
    code: '',
    name: '',
    frequency_unit: 'day',
    frequency_value: 1,
    active: true,
};

export default function Create({ assets = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, asset_id: initialData.asset_id ?? '' });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('apps.inspection-checklists.update', initialData.id));
            return;
        }
        post(route('apps.inspection-checklists.store'));
    };

    return (
        <>
            <Head title={isEdit ? 'Ubah Inspection Checklist' : 'Tambah Inspection Checklist'} />
            <Card title={isEdit ? 'Ubah Inspection Checklist' : 'Tambah Inspection Checklist'} icon={<IconChecklist size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <Input label="Kode" type="text" value={data.code} onChange={(e) => setData('code', e.target.value)} errors={errors.code} />
                    <Input label="Nama" type="text" value={data.name} onChange={(e) => setData('name', e.target.value)} errors={errors.name} />
                    <div>
                        <label className="text-gray-600 text-sm">Asset (opsional)</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.asset_id} onChange={(e) => setData('asset_id', e.target.value)}>
                            <option value="">- Semua Asset -</option>
                            {assets.map((item) => <option key={item.id} value={item.id}>{item.asset_name}</option>)}
                        </select>
                    </div>
                    <div><label className="text-gray-600 text-sm">Tipe</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.inspection_type} onChange={(e) => setData('inspection_type', e.target.value)}><option value="daily_check">Daily Check</option><option value="autonomous_maintenance">Autonomous Maintenance</option><option value="utility_check">Utility Check</option><option value="safety_check">Safety Check</option><option value="facility_check">Facility Check</option></select></div>
                    <div><label className="text-gray-600 text-sm">Unit Frekuensi</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.frequency_unit} onChange={(e) => setData('frequency_unit', e.target.value)}><option value="day">Day</option><option value="week">Week</option><option value="month">Month</option></select></div>
                    <Input label="Nilai Frekuensi" type="number" value={data.frequency_value} onChange={(e) => setData('frequency_value', e.target.value)} errors={errors.frequency_value} />
                </div>
                <label className="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" checked={!!data.active} onChange={(e) => setData('active', e.target.checked)} /> Aktif
                </label>
            </Card>
        </>
    );
}

Create.layout = (page) => <AppLayout children={page} />;
