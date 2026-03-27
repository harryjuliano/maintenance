import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { kpiReliability, assets } = usePage().props;

    return <Create initialData={kpiReliability} assets={assets} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
