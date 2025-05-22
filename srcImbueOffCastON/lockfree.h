#ifndef FS_LOCKFREE_H_8C707AEB7C7235A2FBC5D4EDDF03B008
#define FS_LOCKFREE_H_8C707AEB7C7235A2FBC5D4EDDF03B008

#if _MSC_FULL_VER >= 190023918
#define _ENABLE_ATOMIC_ALIGNMENT_FIX
#endif

#include <boost/lockfree/stack.hpp>
#include <memory>
#include <type_traits>

// Free list pooling helper
template <std::size_t TSize, size_t CAPACITY>
struct LockfreeFreeList {
	using FreeList = boost::lockfree::stack<void*, boost::lockfree::capacity<CAPACITY>>;
	static FreeList& get() {
		static FreeList freeList;
		return freeList;
	}
};

template <typename T, size_t CAPACITY>
class LockfreePoolingAllocator {
public:
	using value_type = T;

	LockfreePoolingAllocator() noexcept = default;

	template <class U>
	LockfreePoolingAllocator(const LockfreePoolingAllocator<U, CAPACITY>&) noexcept {}

	template <class U>
	struct rebind {
		using other = LockfreePoolingAllocator<U, CAPACITY>;
	};

	T* allocate(std::size_t n) {
		if (n != 1) {
			return static_cast<T*>(::operator new(n * sizeof(T)));
		}

		auto& inst = LockfreeFreeList<sizeof(T), CAPACITY>::get();
		void* p;
		if (!inst.pop(p)) {
			p = ::operator new(sizeof(T));
		}
		return static_cast<T*>(p);
	}

	void deallocate(T* p, std::size_t n) noexcept {
		if (n != 1) {
			::operator delete(p);
			return;
		}

		auto& inst = LockfreeFreeList<sizeof(T), CAPACITY>::get();
		if (!inst.bounded_push(p)) {
			::operator delete(p);
		}
	}
};

#endif
