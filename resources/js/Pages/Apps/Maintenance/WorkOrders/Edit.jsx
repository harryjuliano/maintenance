import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { workOrder, assets, workRequests } = usePage().props;

    return <Create initialData={workOrder} assets={assets} workRequests={workRequests} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
