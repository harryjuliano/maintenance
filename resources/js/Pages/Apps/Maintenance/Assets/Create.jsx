import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconDeviceFloppy, IconSettingsPlus } from '@tabler/icons-react';

const defaultData = {
    asset_code: '',
    asset_name: '',
    asset_number: '',
    criticality_level: 'medium',
    maintenance_strategy: 'preventive',
    status: 'active',
    location_note: '',
    notes: '',
};

export default function Create({ initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({
        ...defaultData,
        ...initialData,
    });

    const submit = (e) => {
        e.preventDefault();

        if (isEdit) {
            put(route('apps.assets.update', initialData.id));
            return;
        }

        post(route('apps.assets.store'));
    };

    return (
        <>
            <Head title={isEdit ? 'Ubah Asset' : 'Tambah Asset'} />
            <Card title={isEdit ? 'Ubah Asset' : 'Tambah Asset'} icon={<IconSettingsPlus size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <Input label="Kode Asset" type="text" value={data.asset_code} onChange={(e) => setData('asset_code', e.target.value)} errors={errors.asset_code} />
                    <Input label="Nama Asset" type="text" value={data.asset_name} onChange={(e) => setData('asset_name', e.target.value)} errors={errors.asset_name} />
                    <Input label="Nomor Asset" type="text" value={data.asset_number} onChange={(e) => setData('asset_number', e.target.value)} errors={errors.asset_number} />
                    <Input label="Lokasi" type="text" value={data.location_note ?? ''} onChange={(e) => setData('location_note', e.target.value)} errors={errors.location_note} />
                </div>
                <div className="grid md:grid-cols-3 gap-4 mb-4 text-sm">
                    <div>
                        <label className="text-gray-600 text-sm">Criticality</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.criticality_level} onChange={(e) => setData('criticality_level', e.target.value)}>
                            <option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="critical">Critical</option>
                        </select>
                    </div>
                    <div>
                        <label className="text-gray-600 text-sm">Strategi</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.maintenance_strategy} onChange={(e) => setData('maintenance_strategy', e.target.value)}>
                            <option value="run_to_failure">Run to failure</option><option value="preventive">Preventive</option><option value="predictive">Predictive</option><option value="condition_based">Condition based</option>
                        </select>
                    </div>
                    <div>
                        <label className="text-gray-600 text-sm">Status</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.status} onChange={(e) => setData('status', e.target.value)}>
                            <option value="active">Active</option><option value="standby">Standby</option><option value="under_repair">Under Repair</option><option value="retired">Retired</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label className="text-gray-600 text-sm">Catatan</label>
                    <textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={3} value={data.notes ?? ''} onChange={(e) => setData('notes', e.target.value)} />
                </div>
            </Card>
        </>
    );
}

Create.layout = (page) => <AppLayout children={page} />;
