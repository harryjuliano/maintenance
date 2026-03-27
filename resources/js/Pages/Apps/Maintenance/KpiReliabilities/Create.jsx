import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconDeviceFloppy, IconReportAnalytics } from '@tabler/icons-react';

const defaultData = { kpi_code: '', kpi_period: '', asset_id: '', mtbf_hours: 0, mttr_hours: 0, availability_pct: 0, breakdown_count: 0, emergency_wo_ratio: 0, pm_compliance: 0, status: 'draft' };

export default function Create({ assets = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, asset_id: initialData.asset_id ?? '' });
    const submit = (e) => { e.preventDefault(); isEdit ? put(route('apps.kpi-reliabilities.update', initialData.id)) : post(route('apps.kpi-reliabilities.store')); };

    return <><Head title={isEdit ? 'Ubah KPI Reliability' : 'Tambah KPI Reliability'} /><Card title={isEdit ? 'Ubah KPI Reliability' : 'Tambah KPI Reliability'} icon={<IconReportAnalytics size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}><div className="grid md:grid-cols-2 gap-4 mb-4"><Input label="Kode KPI" type="text" value={data.kpi_code} onChange={(e) => setData('kpi_code', e.target.value)} errors={errors.kpi_code} /><Input label="Periode" type="date" value={data.kpi_period} onChange={(e) => setData('kpi_period', e.target.value)} errors={errors.kpi_period} /><div><label className="text-gray-600 text-sm">Asset</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.asset_id} onChange={(e) => setData('asset_id', e.target.value)}><option value="">- Pilih Asset -</option>{assets.map((item) => <option key={item.id} value={item.id}>{item.asset_name}</option>)}</select></div><Input label="MTBF (hours)" type="number" value={data.mtbf_hours} onChange={(e) => setData('mtbf_hours', e.target.value)} errors={errors.mtbf_hours} /><Input label="MTTR (hours)" type="number" value={data.mttr_hours} onChange={(e) => setData('mttr_hours', e.target.value)} errors={errors.mttr_hours} /><Input label="Availability (%)" type="number" value={data.availability_pct} onChange={(e) => setData('availability_pct', e.target.value)} errors={errors.availability_pct} /><Input label="Breakdown Count" type="number" value={data.breakdown_count} onChange={(e) => setData('breakdown_count', e.target.value)} errors={errors.breakdown_count} /><Input label="Emergency WO Ratio (%)" type="number" value={data.emergency_wo_ratio} onChange={(e) => setData('emergency_wo_ratio', e.target.value)} errors={errors.emergency_wo_ratio} /><Input label="PM Compliance (%)" type="number" value={data.pm_compliance} onChange={(e) => setData('pm_compliance', e.target.value)} errors={errors.pm_compliance} /><div><label className="text-gray-600 text-sm">Status</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.status} onChange={(e) => setData('status', e.target.value)}><option value="draft">Draft</option><option value="published">Published</option></select></div></div></Card></>;
}

Create.layout = (page) => <AppLayout children={page} />;
