import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { rcaCapa, workOrders, users } = usePage().props;

    return <Create initialData={rcaCapa} workOrders={workOrders} users={users} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
