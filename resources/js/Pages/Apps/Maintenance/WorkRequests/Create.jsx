import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconClipboardList, IconDeviceFloppy } from '@tabler/icons-react';

const defaultData = {
    request_no: '',
    request_date: '',
    department: '',
    asset_id: '',
    request_type: 'breakdown',
    urgency_level: 'medium',
    impact_level: 'medium',
    title: '',
    description: '',
    symptom: '',
    status: 'submitted',
};

export default function Create({ assets = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, asset_id: initialData.asset_id ?? '' });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('apps.work-requests.update', initialData.id));
            return;
        }
        post(route('apps.work-requests.store'));
    };

    return (
        <>
            <Head title={isEdit ? 'Ubah Work Request' : 'Tambah Work Request'} />
            <Card title={isEdit ? 'Ubah Work Request' : 'Tambah Work Request'} icon={<IconClipboardList size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}>
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
                </div>
                <div className="grid md:grid-cols-3 gap-4 mb-4 text-sm">
                    <div><label className="text-gray-600 text-sm">Tipe</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.request_type} onChange={(e) => setData('request_type', e.target.value)}><option value="breakdown">Breakdown</option><option value="abnormality">Abnormality</option><option value="inspection_followup">Inspection Followup</option><option value="utility">Utility</option><option value="facility">Facility</option><option value="improvement">Improvement</option></select></div>
                    <div><label className="text-gray-600 text-sm">Urgency</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.urgency_level} onChange={(e) => setData('urgency_level', e.target.value)}><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="emergency">Emergency</option></select></div>
                    <div><label className="text-gray-600 text-sm">Impact</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.impact_level} onChange={(e) => setData('impact_level', e.target.value)}><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="critical">Critical</option></select></div>
                </div>
                <div className="mb-4"><Input label="Judul" type="text" value={data.title} onChange={(e) => setData('title', e.target.value)} errors={errors.title} /></div>
                <div className="grid md:grid-cols-2 gap-4 text-sm">
                    <div><label className="text-gray-600 text-sm">Deskripsi</label><textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={3} value={data.description} onChange={(e) => setData('description', e.target.value)} /></div>
                    <div><label className="text-gray-600 text-sm">Symptom</label><textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={3} value={data.symptom ?? ''} onChange={(e) => setData('symptom', e.target.value)} /></div>
                </div>
            </Card>
        </>
    );
}

Create.layout = (page) => <AppLayout children={page} />;
