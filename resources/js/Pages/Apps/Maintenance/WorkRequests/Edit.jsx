import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { workRequest, assets } = usePage().props;

    return <Create initialData={workRequest} assets={assets} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
