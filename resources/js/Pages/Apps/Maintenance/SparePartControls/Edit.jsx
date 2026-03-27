import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { sparePart, categories, suppliers } = usePage().props;

    return <Create initialData={sparePart} categories={categories} suppliers={suppliers} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
