import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { inspectionChecklist, assets } = usePage().props;

    return <Create initialData={inspectionChecklist} assets={assets} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
