import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { downtimeTracking, assets, workOrders } = usePage().props;

    return <Create initialData={downtimeTracking} assets={assets} workOrders={workOrders} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
