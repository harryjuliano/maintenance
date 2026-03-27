import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconCalendarDue, IconDeviceFloppy } from '@tabler/icons-react';

const defaultData = {
    template_id: '',
    asset_id: '',
    schedule_date: '',
    due_date: '',
    meter_due: '',
    status: 'planned',
    reschedule_reason: '',
    completed_at: '',
};

export default function Create({ assets = [], templates = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, template_id: initialData.template_id ?? '', asset_id: initialData.asset_id ?? '' });

    const submit = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(route('apps.pm-schedulers.update', initialData.id));
            return;
        }
        post(route('apps.pm-schedulers.store'));
    };

    return (
        <>
            <Head title={isEdit ? 'Ubah PM Scheduler' : 'Tambah PM Scheduler'} />
            <Card title={isEdit ? 'Ubah PM Scheduler' : 'Tambah PM Scheduler'} icon={<IconCalendarDue size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}>
                <div className="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label className="text-gray-600 text-sm">Template PM</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.template_id} onChange={(e) => setData('template_id', e.target.value)}>
                            <option value="">- Pilih Template -</option>
                            {templates.map((item) => <option key={item.id} value={item.id}>{item.template_name}</option>)}
                        </select>
                        {errors.template_id && <small className="text-xs text-red-500">{errors.template_id}</small>}
                    </div>
                    <div>
                        <label className="text-gray-600 text-sm">Asset</label>
                        <select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.asset_id} onChange={(e) => setData('asset_id', e.target.value)}>
                            <option value="">- Pilih Asset -</option>
                            {assets.map((item) => <option key={item.id} value={item.id}>{item.asset_name}</option>)}
                        </select>
                        {errors.asset_id && <small className="text-xs text-red-500">{errors.asset_id}</small>}
                    </div>
                    <Input label="Schedule Date" type="date" value={data.schedule_date} onChange={(e) => setData('schedule_date', e.target.value)} errors={errors.schedule_date} />
                    <Input label="Due Date" type="date" value={data.due_date} onChange={(e) => setData('due_date', e.target.value)} errors={errors.due_date} />
                    <Input label="Meter Due (opsional)" type="number" value={data.meter_due} onChange={(e) => setData('meter_due', e.target.value)} errors={errors.meter_due} />
                    <Input label="Completed At (opsional)" type="datetime-local" value={data.completed_at ?? ''} onChange={(e) => setData('completed_at', e.target.value)} errors={errors.completed_at} />
                </div>
                <div className="grid md:grid-cols-2 gap-4">
                    <div><label className="text-gray-600 text-sm">Status</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.status} onChange={(e) => setData('status', e.target.value)}><option value="planned">Planned</option><option value="generated">Generated</option><option value="in_progress">In Progress</option><option value="done">Done</option><option value="overdue">Overdue</option><option value="skipped">Skipped</option><option value="rescheduled">Rescheduled</option></select></div>
                    <Input label="Reschedule Reason" type="text" value={data.reschedule_reason} onChange={(e) => setData('reschedule_reason', e.target.value)} errors={errors.reschedule_reason} />
                </div>
            </Card>
        </>
    );
}

Create.layout = (page) => <AppLayout children={page} />;
