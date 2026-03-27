import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { pmScheduler, assets, templates } = usePage().props;

    return <Create initialData={pmScheduler} assets={assets} templates={templates} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
