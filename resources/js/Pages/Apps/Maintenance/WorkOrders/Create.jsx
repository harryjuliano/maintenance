import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconDeviceFloppy, IconTool } from '@tabler/icons-react';

const defaultData = {
    work_order_no: '',
    work_request_id: '',
    asset_id: '',
    work_order_type: 'corrective',
    priority_level: 'medium',
    maintenance_class: 'unplanned',
    title: '',
    description: '',
    status: 'open',
};

export default function Create({ assets = [], workRequests = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, asset_id: initialData.asset_id ?? '', work_request_id: initialData.work_request_id ?? '' });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('apps.work-orders.update', initialData.id));
            return;
        }
        post(route('apps.work-orders.store'));
    };

    return (
        <>
            <Head title={isEdit ? 'Ubah Work Order' : 'Tambah Work Order'} />
            <Card title={isEdit ? 'Ubah Work Order' : 'Tambah Work Order'} icon={<IconTool size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <Input label="No Work Order" type="text" value={data.work_order_no} onChange={(e) => setData('work_order_no', e.target.value)} errors={errors.work_order_no} />
                    <div>
                        <label className="text-gray-600 text-sm">No Work Request (opsional)</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.work_request_id} onChange={(e) => setData('work_request_id', e.target.value)}>
                            <option value="">- Pilih WR -</option>
                            {workRequests.map((item) => <option key={item.id} value={item.id}>{item.request_no}</option>)}
                        </select>
                    </div>
                    <div>
                        <label className="text-gray-600 text-sm">Asset</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.asset_id} onChange={(e) => setData('asset_id', e.target.value)}>
                            <option value="">- Pilih Asset -</option>
                            {assets.map((asset) => <option key={asset.id} value={asset.id}>{asset.asset_name}</option>)}
                        </select>
                        {errors.asset_id && <small className="text-xs text-red-500">{errors.asset_id}</small>}
                    </div>
                    <Input label="Judul" type="text" value={data.title} onChange={(e) => setData('title', e.target.value)} errors={errors.title} />
                </div>
                <div className="grid md:grid-cols-4 gap-4 mb-4 text-sm">
                    <div><label className="text-gray-600 text-sm">Tipe WO</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.work_order_type} onChange={(e) => setData('work_order_type', e.target.value)}><option value="corrective">Corrective</option><option value="preventive">Preventive</option><option value="predictive">Predictive</option><option value="inspection">Inspection</option><option value="calibration">Calibration</option><option value="improvement">Improvement</option><option value="emergency">Emergency</option></select></div>
                    <div><label className="text-gray-600 text-sm">Priority</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.priority_level} onChange={(e) => setData('priority_level', e.target.value)}><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option><option value="critical">Critical</option></select></div>
                    <div><label className="text-gray-600 text-sm">Class</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.maintenance_class} onChange={(e) => setData('maintenance_class', e.target.value)}><option value="planned">Planned</option><option value="unplanned">Unplanned</option></select></div>
                    <div><label className="text-gray-600 text-sm">Status</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.status} onChange={(e) => setData('status', e.target.value)}><option value="open">Open</option><option value="planned">Planned</option><option value="assigned">Assigned</option><option value="in_progress">In Progress</option><option value="waiting_sparepart">Waiting Sparepart</option><option value="waiting_production_release">Waiting Production Release</option><option value="completed">Completed</option><option value="verified">Verified</option><option value="closed">Closed</option><option value="cancelled">Cancelled</option></select></div>
                </div>
                <div>
                    <label className="text-gray-600 text-sm">Deskripsi</label>
                    <textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={3} value={data.description} onChange={(e) => setData('description', e.target.value)} />
                </div>
            </Card>
        </>
    );
}

Create.layout = (page) => <AppLayout children={page} />;
