import AppLayout from '@/Layouts/AppLayout';
import Card from '@/Components/Card';
import Input from '@/Components/Input';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import { IconBell, IconDeviceFloppy } from '@tabler/icons-react';

const defaultData = { user_id: '', module: '', reference_id: '', title: '', message: '', channel: 'in_app', read_at: '' };

export default function Create({ users = [], initialData = defaultData, isEdit = false }) {
    const { data, setData, post, put, errors } = useForm({ ...defaultData, ...initialData, user_id: initialData.user_id ?? '' });
    const submit = (e) => { e.preventDefault(); isEdit ? put(route('apps.notifications.update', initialData.id)) : post(route('apps.notifications.store')); };

    return <><Head title={isEdit ? 'Ubah Notification' : 'Tambah Notification'} /><Card title={isEdit ? 'Ubah Notification' : 'Tambah Notification'} icon={<IconBell size={18} strokeWidth={1.5} />} form={submit} footer={<Button type="submit" icon={<IconDeviceFloppy size={18} strokeWidth={1.5} />} label="Simpan" variant="gray" />}><div className="grid md:grid-cols-2 gap-4 mb-4"><div><label className="text-gray-600 text-sm">User</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.user_id} onChange={(e) => setData('user_id', e.target.value)}><option value="">- Pilih User -</option>{users.map((item) => <option key={item.id} value={item.id}>{item.name}</option>)}</select></div><Input label="Module" type="text" value={data.module} onChange={(e) => setData('module', e.target.value)} errors={errors.module} /><Input label="Reference ID" type="number" value={data.reference_id ?? ''} onChange={(e) => setData('reference_id', e.target.value)} /><Input label="Title" type="text" value={data.title} onChange={(e) => setData('title', e.target.value)} errors={errors.title} /></div><div className="grid md:grid-cols-2 gap-4 mb-4"><div><label className="text-gray-600 text-sm">Channel</label><select className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" value={data.channel} onChange={(e) => setData('channel', e.target.value)}><option value="in_app">In App</option><option value="email">Email</option><option value="whatsapp">Whatsapp</option></select></div><Input label="Read At" type="datetime-local" value={data.read_at ?? ''} onChange={(e) => setData('read_at', e.target.value)} /></div><div><label className="text-gray-600 text-sm">Message</label><textarea className="w-full mt-2 px-3 py-2 rounded-md border bg-white dark:bg-gray-900 dark:border-gray-800" rows={4} value={data.message} onChange={(e) => setData('message', e.target.value)} /></div></Card></>;
}

Create.layout = (page) => <AppLayout children={page} />;
