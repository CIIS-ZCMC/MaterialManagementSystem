import { Link } from '@inertiajs/react';
import { Check } from 'lucide-react';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';

const GREEN = 'linear-gradient(160deg, #0f8a3e 0%, #0b5a2b 100%)';

// What the system actually does, in the order it happens.
const features = [
    {
        title: 'Verify purchase orders',
        text: 'Match each PO against what the supplier delivers.',
    },
    {
        title: 'Record inspection and acceptance',
        text: 'Keep delivery receipts and inspection reports with the transaction.',
    },
    {
        title: 'Prepare vouchers for Finance',
        text: 'Compile the supporting documents and follow the payment.',
    },
    {
        title: 'Follow up on exceptions',
        text: 'Handle delays, cancellations, and item replacements.',
    },
];

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    return (
        <div className="grid min-h-svh lg:grid-cols-[1.15fr_1fr]">
            {/* ---------- Brand panel (desktop) ---------- */}
            <aside
                className="relative hidden flex-col justify-between overflow-hidden p-12 text-white lg:flex xl:p-16"
                style={{ background: GREEN }}
            >
                {/* Glows */}
                <div
                    aria-hidden
                    className="pointer-events-none absolute -top-32 -right-28 size-96 rounded-full"
                    style={{
                        background: '#f5e400',
                        opacity: 0.35,
                        filter: 'blur(70px)',
                    }}
                />
                <div
                    aria-hidden
                    className="pointer-events-none absolute -bottom-32 -left-28 size-80 rounded-full"
                    style={{
                        background: '#1fb35a',
                        opacity: 0.55,
                        filter: 'blur(70px)',
                    }}
                />

                {/* Large faint seal fills the empty corner */}
                <img
                    src="/images/zcmc.png"
                    alt=""
                    aria-hidden
                    className="pointer-events-none absolute -right-28 -bottom-24 w-[34rem] max-w-none select-none"
                    style={{ opacity: 0.07 }}
                />

                <div className="relative z-10 my-auto max-w-2xl">
                    <Link href={home()} className="inline-block">
                        <img
                            src="/images/zcmc.png"
                            alt="Zamboanga City Medical Center seal"
                            className="mb-6 h-24 w-auto drop-shadow-[0_10px_18px_rgba(0,0,0,0.28)] xl:h-28"
                        />
                    </Link>

                    <p className="mb-2 text-base font-medium text-[#fbee4d] xl:text-lg">
                        Department of Health
                    </p>
                    <h1 className="text-5xl leading-[1.08] font-bold tracking-tight xl:text-6xl">
                        Zamboanga City Medical Center
                    </h1>
                    <p className="mt-5 inline-block rounded-full border border-white/25 bg-white/15 px-5 py-2 text-base font-medium xl:text-lg">
                        Material Management Section
                    </p>

                    <div className="mt-9 grid gap-x-8 gap-y-6 border-t border-white/15 pt-9 sm:grid-cols-2">
                        {features.map((feature, i) => (
                            <div
                                key={feature.title}
                                className="feature-in flex items-start gap-3.5"
                                style={{ animationDelay: `${i * 180}ms` }}
                            >
                                <span className="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-[#f5e400] text-[#0b5a2b]">
                                    <Check
                                        className="size-3.5"
                                        strokeWidth={3}
                                        aria-hidden
                                    />
                                </span>
                                <div>
                                    <p className="text-base font-semibold xl:text-lg">
                                        {feature.title}
                                    </p>
                                    <p className="mt-1 text-sm leading-snug text-white/75 xl:text-[0.95rem]">
                                        {feature.text}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                <p className="relative z-10 text-sm text-white/70">
                    &copy; {new Date().getFullYear()} ZCMC. For authorized
                    personnel only.
                </p>
            </aside>

            {/* ---------- Form side ---------- */}
            <main className="flex min-h-svh flex-col bg-muted/40 lg:items-center lg:justify-center lg:p-8">
                {/* Green header (phone and tablet) */}
                <header
                    className="relative flex items-center gap-4 overflow-hidden px-5 pt-8 pb-16 text-white sm:flex-col sm:gap-3 sm:px-6 sm:pt-11 sm:pb-20 sm:text-center lg:hidden"
                    style={{ background: GREEN }}
                >
                    <div
                        aria-hidden
                        className="pointer-events-none absolute -top-20 -right-16 size-56 rounded-full"
                        style={{
                            background: '#f5e400',
                            opacity: 0.32,
                            filter: 'blur(50px)',
                        }}
                    />
                    <div
                        aria-hidden
                        className="pointer-events-none absolute -bottom-20 -left-16 size-52 rounded-full"
                        style={{
                            background: '#1fb35a',
                            opacity: 0.55,
                            filter: 'blur(50px)',
                        }}
                    />

                    <Link href={home()} className="relative z-10 shrink-0">
                        <img
                            src="/images/zcmc.png"
                            alt="Zamboanga City Medical Center seal"
                            className="h-16 w-auto drop-shadow-[0_10px_16px_rgba(0,0,0,0.3)] sm:h-20"
                        />
                    </Link>
                    <div className="relative z-10 leading-tight">
                        <p className="mb-1 text-xs font-medium text-[#fbee4d]">
                            Department of Health
                        </p>
                        <p className="text-lg font-bold sm:text-2xl">
                            Zamboanga City Medical Center
                        </p>
                        <p className="mt-2 inline-block rounded-full border border-white/20 bg-white/15 px-3 py-1 text-xs font-medium sm:text-sm">
                            Material Management Section
                        </p>
                    </div>
                </header>

                {/* Form card: bottom sheet on phones, floating card on larger screens */}
                <div className="relative z-10 -mt-8 flex-1 rounded-t-[28px] bg-card px-6 pt-8 pb-8 shadow-[0_-12px_30px_rgba(11,90,43,0.18)] sm:mx-auto sm:-mt-12 sm:mb-10 sm:w-full sm:max-w-md sm:flex-none sm:rounded-2xl sm:border sm:p-9 sm:shadow-xl lg:mt-0 lg:mb-0 lg:p-10">
                    <div className="mb-7">
                        <h2 className="text-3xl font-bold tracking-tight">
                            {title}
                        </h2>
                        <div
                            aria-hidden
                            className="mt-3 h-1.5 w-14 rounded-full"
                            style={{
                                background:
                                    'linear-gradient(90deg, #12a04a 0 60%, #f5e400 60% 100%)',
                            }}
                        />
                        <p className="mt-3 text-sm text-muted-foreground">
                            {description}
                        </p>
                    </div>

                    {children}

                    <p className="mt-6 text-center text-sm text-muted-foreground">
                        Need an account or forgot your password? Contact the
                        system administrator.
                    </p>
                </div>
            </main>

            {/* One-time reveal of the feature list; skipped if the user prefers reduced motion */}
            <style>{`
                @keyframes feature-in { from { opacity: 0; } to { opacity: 1; } }
                @media (prefers-reduced-motion: no-preference) {
                    .feature-in { animation: feature-in 600ms ease-out both; }
                }
            `}</style>
        </div>
    );
}