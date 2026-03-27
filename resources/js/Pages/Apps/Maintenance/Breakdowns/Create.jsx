import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconAlertTriangle, IconDeviceFloppy } from '@tabler/icons-react';

const defaultData = {
    request_no: '',
    request_date: '',
    department: '',
    asset_id: '',
    urgency_level: 'high',
    impact_level: 'high',
    title: '',
    description: '',
    symptom: '',
    breakdown_start_at: '',
    affects_production: true,
    estimated_production_loss: '',
    status: 'submitted',
};

export default function Create({ assets = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, asset_id: initialData.asset_id ?? '' });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('apps.breakdowns.update', initialData.id));
            return;
        }
        post(route('apps.breakdowns.store'));
    };

    return (
        <>
            <Head title={isEdit ? 'Ubah Breakdown' : 'Tambah Breakdown'} />
            <Card title={isEdit ? 'Ubah Breakdown' : 'Tambah Breakdown'} icon={<IconAlertTriangle size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <Input label="No Request" type="text" value={data.request_no} onChange={(e) => setData('request_no', e.target.value)} errors={errors.request_no} />
                    <Input label="Tanggal Request" type="date" value={data.request_date} onChange={(e) => setData('request_date', e.target.value)} errors={errors.request_date} />
                    <Input label="Departemen" type="text" value={data.department ?? ''} onChange={(e) => setData('department', e.target.value)} errors={errors.department} />
                    <div>
                        <label className="text-gray-600 text-sm">Asset (opsional)</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.asset_id} onChange={(e) => setData('asset_id', e.target.value)}>
                            <option value="">- Pilih Asset -</option>
                            {assets.map((asset) => <option key={asset.id} value={asset.id}>{asset.asset_name}</option>)}
                        </select>
                    </div>
                    <Input label="Mulai Breakdown" type="datetime-local" value={data.breakdown_start_at ?? ''} onChange={(e) => setData('breakdown_start_at', e.target.value)} errors={errors.breakdown_start_at} />
                    <Input label="Estimasi Loss Produksi" type="number" value={data.estimated_production_loss ?? ''} onChange={(e) => setData('estimated_production_loss', e.target.value)} errors={errors.estimated_production_loss} />
                </div>
                <div className="grid md:grid-cols-3 gap-4 mb-4 text-sm">
                    <div><label className="text-gray-600 text-sm">Urgency</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.urgency_level} onChange={(e) => setData('urgency_level', e.target.value)}><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="emergency">Emergency</option></select></div>
                    <div><label className="text-gray-600 text-sm">Impact</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.impact_level} onChange={(e) => setData('impact_level', e.target.value)}><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="critical">Critical</option></select></div>
                    <div><label className="text-gray-600 text-sm">Status</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.status} onChange={(e) => setData('status', e.target.value)}><option value="draft">Draft</option><option value="submitted">Submitted</option><option value="reviewed">Reviewed</option><option value="approved">Approved</option><option value="rejected">Rejected</option><option value="converted">Converted</option><option value="closed">Closed</option></select></div>
                </div>
                <div className="mb-4"><Input label="Judul" type="text" value={data.title} onChange={(e) => setData('title', e.target.value)} errors={errors.title} /></div>
                <div className="grid md:grid-cols-2 gap-4 text-sm">
                    <div><label className="text-gray-600 text-sm">Deskripsi</label><textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={3} value={data.description} onChange={(e) => setData('description', e.target.value)} /></div>
                    <div><label className="text-gray-600 text-sm">Symptom</label><textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={3} value={data.symptom ?? ''} onChange={(e) => setData('symptom', e.target.value)} /></div>
                </div>
                <div className="mt-4">
                    <label className="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                        <input type="checkbox" checked={!!data.affects_production} onChange={(e) => setData('affects_production', e.target.checked)} />
                        Mempengaruhi produksi
                    </label>
                </div>
            </Card>
        </>
    );
}

Create.layout = (page) => <AppLayout children={page} />;
