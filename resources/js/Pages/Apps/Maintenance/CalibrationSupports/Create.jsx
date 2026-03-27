import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconDeviceFloppy, IconRulerMeasure } from '@tabler/icons-react';

const defaultData = {
    calibration_no: '',
    asset_id: '',
    checklist_name: '',
    standard_reference: '',
    scheduled_at: '',
    performed_at: '',
    next_due_at: '',
    status: 'planned',
    result: 'pending',
    note: '',
};

export default function Create({ assets = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, asset_id: initialData.asset_id ?? '' });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('apps.calibration-supports.update', initialData.id));
            return;
        }
        post(route('apps.calibration-supports.store'));
    };

    return (
        <>
            <Head title={isEdit ? 'Ubah Calibration Support' : 'Tambah Calibration Support'} />
            <Card title={isEdit ? 'Ubah Calibration Support' : 'Tambah Calibration Support'} icon={<IconRulerMeasure size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <Input label="No Kalibrasi" type="text" value={data.calibration_no} onChange={(e) => setData('calibration_no', e.target.value)} errors={errors.calibration_no} />
                    <Input label="Checklist" type="text" value={data.checklist_name} onChange={(e) => setData('checklist_name', e.target.value)} errors={errors.checklist_name} />
                    <div>
                        <label className="text-gray-600 text-sm">Asset (opsional)</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.asset_id} onChange={(e) => setData('asset_id', e.target.value)}>
                            <option value="">- Pilih Asset -</option>
                            {assets.map((item) => <option key={item.id} value={item.id}>{item.asset_name}</option>)}
                        </select>
                    </div>
                    <Input label="Standard Reference" type="text" value={data.standard_reference} onChange={(e) => setData('standard_reference', e.target.value)} errors={errors.standard_reference} />
                    <Input label="Scheduled At" type="date" value={data.scheduled_at} onChange={(e) => setData('scheduled_at', e.target.value)} errors={errors.scheduled_at} />
                    <Input label="Performed At" type="date" value={data.performed_at ?? ''} onChange={(e) => setData('performed_at', e.target.value)} errors={errors.performed_at} />
                    <Input label="Next Due At" type="date" value={data.next_due_at ?? ''} onChange={(e) => setData('next_due_at', e.target.value)} errors={errors.next_due_at} />
                </div>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <div><label className="text-gray-600 text-sm">Status</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.status} onChange={(e) => setData('status', e.target.value)}><option value="planned">Planned</option><option value="in_progress">In Progress</option><option value="completed">Completed</option><option value="overdue">Overdue</option><option value="cancelled">Cancelled</option></select></div>
                    <div><label className="text-gray-600 text-sm">Result</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.result} onChange={(e) => setData('result', e.target.value)}><option value="pending">Pending</option><option value="pass">Pass</option><option value="fail">Fail</option></select></div>
                </div>
                <div>
                    <label className="text-gray-600 text-sm">Catatan</label>
                    <textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={3} value={data.note} onChange={(e) => setData('note', e.target.value)} />
                </div>
            </Card>
        </>
    );
}

Create.layout = (page) => <AppLayout children={page} />;
